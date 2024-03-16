<?php

namespace App\Http\Controllers\Api;

use DB;
use Mail;
use Auth;
use Carbon\Carbon;

use App\Models\BloodGroup;
use App\Models\MaritalStatus;
use App\Models\PrayerGroup;
use App\Models\Relationship;

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
            $per_pg='';

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
            $per_pg='';

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
            $per_pg='';

            $prayer_group = PrayerGroup::select('id','group_name','leader','leader_phone_number')
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

    public function Relationships(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $relationships = Relationship::select('id','relation_name')->where('status',1);

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

}
