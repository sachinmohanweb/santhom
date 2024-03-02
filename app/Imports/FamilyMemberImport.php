<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;

use App\Models\Family;
use App\Models\BloodGroup;
use App\Models\PrayerGroup;
use App\Models\Relationship;
use App\Models\FamilyMember;
use App\Models\MaritalStatus;

use DB;
use Cache;

class FamilyMemberImport implements ToCollection,WithHeadingRow,WithValidation,WithChunkReading
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

                $exist_family= Family::where('family_code',$row['family_code'])->first();

                if(!$exist_family){

                    $details['family_code']    =$row['family_code'];
                    $details['family_name']    =$row['family_name'];

                    $row['prayer_group'] = trim($row['prayer_group']);
                    $prayer_group=PrayerGroup::where('group_name',$row['prayer_group'])->first();
                    if(!$prayer_group){
                        throw new \Exception("PrayerGroup unidentified Row-".$key+2);
                    }
                    $details['prayer_group_id']     =$prayer_group['id'];
                    $details['family_email']        =$row['family_email'];
                    $details['address1']            =$row['address1'];
                    $details['pincode']             =$row['pincode'];

                    if(isset($row['address2'])){
                        $details['address2']    =$row['address2'];
                    }else{
                        $details['address2']    =null;
                    }

                    if(isset($row['post_office'])){
                        $details['post_office']    =$row['post_office'];
                    }else{
                        $details['post_office']    =null;
                    }

                    $details['status']    = 1 ;

                    $NewFamily = Family::create($details);

                    $family_id = $NewFamily['id'];

                }else{

                    $family_id = $exist_family['id'];
                }

                $member_details['family_id']  =$family_id;
                $member_details['name']    =$row['name'];
                $member_details['gender']     =$row['gender'];

                $unixTimestampDOB = ($row['date_of_birth'] - 25569) * 86400;
                $member_details['dob']        = date('Y-m-d', $unixTimestampDOB);

                $row['relationship'] = trim($row['relationship']);
                $relationship=Relationship::where('relation_name',$row['relationship'])->first();
                if(!$relationship){
                    throw new \Exception("Relationship unidentified Row-".$key+2);
                } 
                $member_details['relationship_id']    =$relationship['id'];
                if($relationship['id']==1){
                    $member_details['head_of_family']    =1;
                }else{
                    $member_details['head_of_family']    =0;
                }

                if(isset($row['title'])){
                    $member_details['title']    =$row['title'];
                }else{
                    $member_details['title']    =null;
                }

                if(isset($row['nickname'])){
                    $member_details['nickname']    =$row['nickname'];
                }else{
                    $member_details['nickname']    =null;
                }

                if(isset($row['date_of_baptism'])){
                    $unixTimestampDOBp = ($row['date_of_baptism'] - 25569) * 86400;
                    $member_details['date_of_baptism']    = date('Y-m-d', $unixTimestampDOBp);
                }else{
                    $member_details['date_of_baptism']    =null;
                }

                if(isset($row['blood_group'])){
                    $row['blood_group'] = trim($row['blood_group']);
                    $blood_group=BloodGroup::where('blood_group_name',$row['blood_group'])->first();
                    if(!$blood_group){
                        throw new \Exception("Bloodgroup unidentified Row-".$key+2);
                    } 
                    $member_details['blood_group_id']    =$blood_group['id'];
                }else{
                    $member_details['blood_group_id']    =null;
                }

                if(isset($row['marital_status'])){
                    $row['marital_status'] = trim($row['marital_status']);
                    $marital_status=MaritalStatus::where('marital_status_name',$row['marital_status'])->first();
                    if(!$marital_status){
                        throw new \Exception("Marital Status unidentified Row-".$key+2);
                    } 
                    $member_details['marital_status_id']    =$marital_status['id'];
                }else{
                    $member_details['marital_status_id']    =null;
                }

                if(isset($row['date_of_marriage'])){
                    $unixTimestampDOM = ($row['date_of_marriage'] - 25569) * 86400;
                    $member_details['date_of_marriage']    = date('Y-m-d', $unixTimestampDOM);
                }else{
                    $member_details['date_of_marriage']    =null;
                }

                if(isset($row['qualification'])){
                    $member_details['qualification']    =$row['qualification'];
                }else{
                    $member_details['qualification']    =null;
                }

                if(isset($row['occupation'])){
                    $member_details['occupation']    =$row['occupation'];
                }else{
                    $member_details['occupation']    =null;
                }

                if(isset($row['company_name'])){
                    $member_details['company_name']    =$row['company_name'];
                }else{
                    $member_details['company_name']    =null;
                }

                if(isset($row['email'])){
                    $member_details['email']    =$row['email'];
                }else{
                    $member_details['email']    =null;
                }

                if(isset($row['mobile'])){
                    $member_details['mobile']    =$row['mobile'];
                }else{
                    $member_details['mobile']    =null;
                }

                if(isset($row['alt_contact_no'])){
                    $member_details['alt_contact_no']    =$row['alt_contact_no'];
                }else{
                    $member_details['alt_contact_no']    =null;
                }

                if(isset($row['date_of_death'])){
                    $unixTimestampDOD = ($row['date_of_death'] - 25569) * 86400;
                    $member_details['date_of_death']    = date('Y-m-d', $unixTimestampDOD);
                }else{
                    $member_details['date_of_death']    =null;
                }
                
                $member_details['status']    =1;
                $NewMember = FamilyMember::create($member_details); 

                $processedRows++;
                $progress = ceil(($processedRows / $totalRows) * 100);
                Cache::put('import_progress', $progress, now()->addSeconds(2));  
                
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
            'family_code'   => 'required',
            'family_name'   => 'required',
            'prayer_group'  => 'required',
            'family_email'  => 'required',
            'address1'      => 'required',
            'pincode'       => 'required',
            'name'          => 'required',
            'gender'        => 'required',
            'date_of_birth'    => 'required',
            'relationship'    => 'required',

           
        ];
    }
    public function customValidationMessages()
    {
        return [
            'family_code.required'          => 'family_code should not be empty',
            'family_name.required'          => 'family_name should not be empty',
            'prayer_group.required'         => 'prayer_group should not be empty',
            'family_email.required'         => 'family_email should not be empty',
            'address1.required'             => 'address1 should not be empty',
            'pincode.required'              => 'pincode should not be empty',
            'name.required'                 => 'name should not be empty',
            'gender.required'               => 'gender should not be empty',
            'date_of_birth.required'        => 'date_of_birth should not be empty',
            'relationship.required'         => 'relationship should not be empty',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
