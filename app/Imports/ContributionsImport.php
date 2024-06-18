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

    public function __construct()
    {

    }
    public function collection(Collection $rows)
    {  
        try{
            DB::beginTransaction();
            
            $processedRows = 0;
            $totalRows = $rows->count();

            foreach ($rows as $key=>$row) {

                $family = Family::where('family_code',$row['family_code'])->first();
                if(!$family){
                    throw new \Exception("Family code  unidentified Row");
                }
                if(!$family->headOfFamily){
                    throw new \Exception("Family head  unidentified Row");
                }
                
                $contribution_details['family_id']   = $family->id;
                $contribution_details['family_head_id']   = $family->headOfFamily->id;               

                if($row['monthly_subscription']){
                    $contribution_details['category_id']   = 1;
                    $contribution_details['amount']   = $row['monthly_subscription'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }
                if($row['parish_feast']){
                    $contribution_details['category_id']   = 2;
                    $contribution_details['amount']   = $row['parish_feast'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }
                if($row['parish_day']){
                    $contribution_details['category_id']   = 3;
                    $contribution_details['amount']   = $row['parish_day'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }
                if($row['first_offering']){
                    $contribution_details['category_id']   = 4;
                    $contribution_details['amount']   = $row['first_offering'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }                
                if($row['carol']){
                    $contribution_details['category_id']   = 5;
                    $contribution_details['amount']   = $row['carol'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }

                if($row['good_friday']){
                    $contribution_details['category_id']   = 6;
                    $contribution_details['amount']   = $row['good_friday'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }                
                if($row['8_nombu']){
                    $contribution_details['category_id']   = 7;
                    $contribution_details['amount']   = $row['8_nombu'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }                
                if($row['mission_sunday']){
                    $contribution_details['category_id']   = 8;
                    $contribution_details['amount']   = $row['mission_sunday'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }
                if($row['education_help']){
                    $contribution_details['category_id']   = 9;
                    $contribution_details['amount']   = $row['education_help'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }
                if($row['seminary_day']){
                    $contribution_details['category_id']   = 10;
                    $contribution_details['amount']   = $row['seminary_day'];
                    $NewContribution = PaymentDetail::create($contribution_details); 
                }
                if($row['others']){
                    $contribution_details['category_id']   = 11;
                    $contribution_details['amount']   = $row['others'];
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
