<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;

use App\Models\Family;
use App\Models\PaymentDetail;
use App\Models\PaymentCategory;

use DB;
use Cache;

class ContributionsImport implements ToCollection,WithHeadingRow,WithValidation,WithChunkReading
{

    use Importable;
    protected $importResult;
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }
    public function collection(Collection $rows)
    {  
        try{
            DB::beginTransaction();
            
            $processedRows = 0;
            $totalRows = $rows->count();

            PaymentDetail::whereNotNull('id')->delete();  

            foreach ($rows as $key=>$row) {

                $family = Family::where('family_code',$row['family_code'])->first();
                if(!$family){
                    throw new \Exception("Family code  unidentified Row");
                }
                if(!$family->headOfFamily){
                    throw new \Exception("Family head  unidentified Row");
                }
                
                $contribution_details = [
                    'effective_date' => $this->date,
                    'family_id' => $family->id,
                    'family_head_id' => $family->headOfFamily->id
                ];

                $categories = [
                    'monthly_subscription' => 1,
                    'parish_feast' => 2,
                    'parish_day' => 3,
                    'first_offering' => 4,
                    'carol' => 5,
                    'good_friday' => 6,
                    'ettunomb' => 7,
                    'mission_sunday' => 8,
                    'education_help' => 9,
                    'birthday' => 10,
                    'donation_general' => 11,
                    'seminary_day' => 12,
                ];
                              
                foreach ($categories as $field => $category_id) {

                    $contribution_details['category_id'] = $category_id;
                    $contribution_details['amount'] = $row[$field];
                    $NewContribution = PaymentDetail::create($contribution_details);
                }
                
                $processedRows++;
                $progress = ceil(($processedRows / $totalRows) * 100);
                Cache::put('import_progress_contributions', $progress, now()->addSeconds(2));  
                
            }
            DB::commit();
            $return['result'] = "Success";
            $return['message'] = "successfully imported";
        }catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = "Failed due to " . $e->getMessage();
            if (isset($key)) {
                $errorMessage .= " at row " . ($key+2);
            }
            $return['result'] = "Failed";
            $return['message'] = $errorMessage;
        }

        $this->setImportResult($return);

    }

    public function setImportResult($return)
    {
        $this->importResult = $return;
    }

    public function getImportResult()
    {
        return $this->importResult;
    }  

    public function rules(): array
    {
        return [
            'family_code'   => 'required'        
        ];
    }
    public function customValidationMessages()
    {
        return [
            'family_code.required'        => 'family code should not be empty'
           
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
