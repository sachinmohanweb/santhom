<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;

use App\Models\BibleVerse;

use DB;
use Cache;

class BibleVerseImport implements ToCollection,WithHeadingRow,WithValidation,WithChunkReading
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

                $bible_verse_details['verse']  =$row['verse'];
                $bible_verse_details['ref']    =$row['ref'];

                $NewBibleVerse = BibleVerse::create($bible_verse_details); 

                $processedRows++;
                $progress = ceil(($processedRows / $totalRows) * 100);
                Cache::put('import_progress_bible', $progress, now()->addSeconds(2));  
                
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
            'verse'   => 'required',
            'ref'   => 'required',           
        ];
    }
    public function customValidationMessages()
    {
        return [
            'verse.required'        => 'Verse should not be empty',
            'ref.required'          => 'Reference should not be empty',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
