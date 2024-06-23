<?php

namespace App\Http\Controllers\Api;

use DB;
use Mail;
use Auth;
use Artisan;
use Carbon\Carbon;

use App\Models\Family;
use App\Models\BloodGroup;
use App\Models\PrayerGroup;
use App\Models\Relationship;
use App\Models\Organization;
use App\Models\FamilyMember;
use App\Models\MaritalStatus;

use App\Http\Repositories\UserRepository;


use App\Helpers\Outputer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function __construct(Outputer $outputer,UserRepository $userRepo){

        $this->outputer = $outputer;
        $this->userRepo = $userRepo;
    }

    public function BloodGroups(Request $request){

        try {

            $pg_no='';
            $per_pg=100;

            $bloodgroups = BloodGroup::select('id','blood_group_name')->where('status',1);

            if($request['search_word']){
                $bloodgroups->where('blood_group_name','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $bloodgroups=$bloodgroups->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($bloodgroups)) {
                $return['result']=  "Empty blood group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $bloodgroups->total(),
                "per_page" => $bloodgroups->perPage(),
                "current_page" => $bloodgroups->currentPage(),
                "last_page" => $bloodgroups->lastPage(),
                "next_page_url" => $bloodgroups->nextPageUrl(),
                "prev_page_url" => $bloodgroups->previousPageUrl(),
                "from" => $bloodgroups->firstItem(),
                "to" => $bloodgroups->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($bloodgroups->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function MaritatStatuses(Request $request){

        try {

            $pg_no='';
            $per_pg=100;

            $marital_status = MaritalStatus::select('id','marital_status_name')->where('status',1);

            if($request['search_word']){
                $marital_status->where('marital_status_name','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $marital_status=$marital_status->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($marital_status)) {
                $return['result']=  "Empty marital status list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $marital_status->total(),
                "per_page" => $marital_status->perPage(),
                "current_page" => $marital_status->currentPage(),
                "last_page" => $marital_status->lastPage(),
                "next_page_url" => $marital_status->nextPageUrl(),
                "prev_page_url" => $marital_status->previousPageUrl(),
                "from" => $marital_status->firstItem(),
                "to" => $marital_status->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($marital_status->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function PrayerGroups(Request $request){

        try {

            $pg_no='';
            $per_pg=100;

            $prayer_group = PrayerGroup::select('id','group_name','leader_id','leader',
                'leader_phone_number','coordinator_id','coordinator_name','coordinator_phone')
                            ->where('status',1);

            if($request['search_word']){
                $prayer_group->where('group_name','like',$request['search_word'].'%')
                            ->orwhere('leader','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $prayer_group=$prayer_group->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($prayer_group)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $prayer_group->total(),
                "per_page" => $prayer_group->perPage(),
                "current_page" => $prayer_group->currentPage(),
                "last_page" => $prayer_group->lastPage(),
                "next_page_url" => $prayer_group->nextPageUrl(),
                "prev_page_url" => $prayer_group->previousPageUrl(),
                "from" => $prayer_group->firstItem(),
                "to" => $prayer_group->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($prayer_group->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function PrayerGroupDetails(Request $request){

        try {

            $prayer_group = PrayerGroup::select('id','group_name','leader_id','leader',
                'leader_phone_number','coordinator_id','coordinator_name','coordinator_phone')
                            ->where('id',$request['id'])->first();

            $members = FamilyMember::select('family_members.id','family_members.name','family_members.image','family_members.family_id')
                        ->join('families', 'family_members.family_id', '=', 'families.id')
                        ->where('families.prayer_group_id',$request['id'])
                        ->whereNull('family_members.date_of_death')
                        ->where('families.family_code', '!=', 'CP001')
                        ->get();
                        
            $members->transform(function ($item, $key) {
                if ($item->image !== null) {
                    $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            $return['prayer_group']  =  $prayer_group;
            $return['members']  =  $members;

            return $this->outputer->code(200)->success($return)->json();    

            }catch (\Exception $e) {

                $return['result']=$e->getMessage();
                return $this->outputer->code(422)->error($return)->json();
            }
    }

    public function Organizations(Request $request){

        try {

            $pg_no='';
            $per_pg=100;

            $organizations=Organization::select('id','organization_name','coordinator','coordinator_phone_number')
                            ->where('status',1);

            if($request['search_word']){
                $organizations->where('organization_name','like','%' . $request['search_word'].'%')
                            ->orwhere('coordinator','like',$request['search_word'].'%');

            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $organizations=$organizations->orderBy('id', 'desc')
                                ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($organizations)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $organizations->total(),
                "per_page" => $organizations->perPage(),
                "current_page" => $organizations->currentPage(),
                "last_page" => $organizations->lastPage(),
                "next_page_url" => $organizations->nextPageUrl(),
                "prev_page_url" => $organizations->previousPageUrl(),
                "from" => $organizations->firstItem(),
                "to" => $organizations->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($organizations->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }
    public function OrganizationDetails(Request $request){

        try {

            $organization = Organization::select('id','organization_name','coordinator','coordinator_phone_number')
                            ->where('id',$request['id'])->first();

            $members = FamilyMember::select('family_members.id','family_members.name','family_members.image','family_members.family_id','organization_officers.position','organization_officers.officer_phone_number')
                        ->join('organization_officers', 'family_members.id', '=', 'organization_officers.member_id')
                        ->where('organization_officers.organization_id',$request['id'])->get();
                        
            $members->transform(function ($item, $key) {
                if ($item->image !== null) {
                    $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            $return['organization']  =  $organization;
            $return['members']  =  $members;

            return $this->outputer->code(200)->success($return)->json();    

            }catch (\Exception $e) {

                $return['result']=$e->getMessage();
                return $this->outputer->code(422)->error($return)->json();
            }
    }

    public function Relationships(Request $request){

        try {

            $pg_no='';
            $per_pg=100;

            $relationships = Relationship::select('id','relation_name')->where('status',1)->where('id','!=',1);

            if($request['search_word']){
                $relationships->where('relation_name','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $relationships=$relationships->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($relationships)) {
                $return['result']=  "Empty relations list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $relationships->total(),
                "per_page" => $relationships->perPage(),
                "current_page" => $relationships->currentPage(),
                "last_page" => $relationships->lastPage(),
                "next_page_url" => $relationships->nextPageUrl(),
                "prev_page_url" => $relationships->previousPageUrl(),
                "from" => $relationships->firstItem(),
                "to" => $relationships->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($relationships->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function ClearCache(Request $request) {
        
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return "Cleared!";
    }
}
