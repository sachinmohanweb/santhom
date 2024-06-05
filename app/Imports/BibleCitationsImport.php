<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;

use App\Models\BiblicalCitation;

use DB;
use Cache;

class BibleCitationsImport implements ToCollection,WithHeadingRow,WithValidation,WithChunkReading
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

                $unixTimestampDOB = ($row['date'] - 25569) * 86400;
                $date_value = date('Y-m-d', $unixTimestampDOB);
                $rept_date=BiblicalCitation::where('date',$date_value)->first();
                if($rept_date){
                    throw new \Exception("date  already exist-");
                }  
                $bible_citation_details['date']        = date('Y-m-d', $unixTimestampDOB);
                $bible_citation_details['reference']    =$row['ref'];

                if(isset($row['note'])){
                    $bible_citation_details['note1']    =$row['note'];
                }else{
                    $bible_citation_details['note1']    =null;
                }
                if(isset($row['others_details'])){
                    $bible_citation_details['note2']    =$row['others_details'];
                }else{
                    $bible_citation_details['note2']    =null;
                }

                $NewBibleCitation = BiblicalCitation::create($bible_citation_details); 

                $processedRows++;
                $progress = ceil(($processedRows / $totalRows) * 100);
                Cache::put('import_progress_bible_citations', $progress, now()->addSeconds(2));  
                
            }
            DB::commit();
            $return['result'] = "Success";
            $return['message'] = "successfully imported";
        }catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = "Failed due to " . $e->getMessage();
            if (isset($key)) {
                $errorMessage .= " at row " . ($key + 2);
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
            'date'   => 'required',
            'ref'   => 'required',           
        ];
    }
    public function customValidationMessages()
    {
        return [
            'date.required'        => 'date should not be empty',
            'ref.required'          => 'Reference should not be empty',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
