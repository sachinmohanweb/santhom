<?php

namespace App\Http\Controllers\Api;

use DB;
use Mail;
use Auth;
use Carbon\Carbon;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\BibleVerse;
use App\Models\Event;
use App\Models\NewsAnnouncement;
use App\Models\Notification;
use App\Models\Obituary;
use App\Models\Organization;
use App\Models\VicarMessage;
use App\Models\PrayerGroup;

use App\Http\Repositories\UserRepository;


use App\Helpers\Outputer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct(Outputer $outputer,UserRepository $userRepo){

        $this->outputer = $outputer;
        $this->userRepo = $userRepo;
    }

    public function Families(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $families = Family::select('*')->where('status',1);

            if($request['search_word']){
                $families->where('family_name','like',$request['search_word'].'%')
                            ->orwhere('family_code','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $families=$families->orderBy('family_name','asc')
                                ->paginate($perPage=$per_pg,[],'',$page =$pg_no);

            if(empty($families)) {
                $return['result']=  "Empty family list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $families->total(),
                "per_page" => $families->perPage(),
                "current_page" => $families->currentPage(),
                "last_page" => $families->lastPage(),
                "next_page_url" => $families->nextPageUrl(),
                "prev_page_url" => $families->previousPageUrl(),
                "from" => $families->firstItem(),
                "to" => $families->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($families->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Members(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $members = FamilyMember::select('*')->where('status',1);

            if($request['search_word']){
                $members->where('name','like',$request['search_word'].'%')
                            ->orwhere('nickname','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $members=$members->orderBy('name', 'asc')->paginate($perPage=$per_pg,[],'',$page =$pg_no);

            if(empty($members)) {
                $return['result']=  "Empty bible verse list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $members->total(),
                "per_page" => $members->perPage(),
                "current_page" => $members->currentPage(),
                "last_page" => $members->lastPage(),
                "next_page_url" => $members->nextPageUrl(),
                "prev_page_url" => $members->previousPageUrl(),
                "from" => $members->firstItem(),
                "to" => $members->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($members->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function BibleVerses(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $bible_verse = BibleVerse::select('id','ref','verse')->where('status',1);

            if($request['search_word']){
                $bible_verse->where('ref','like',$request['search_word'].'%')
                            ->orwhere('verse','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $bible_verse=$bible_verse->orderBy('id', 'desc')->paginate($perPage=$per_pg,[],'',$page =$pg_no);

            if(empty($bible_verse)) {
                $return['result']=  "Empty bible verse list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $bible_verse->total(),
                "per_page" => $bible_verse->perPage(),
                "current_page" => $bible_verse->currentPage(),
                "last_page" => $bible_verse->lastPage(),
                "next_page_url" => $bible_verse->nextPageUrl(),
                "prev_page_url" => $bible_verse->previousPageUrl(),
                "from" => $bible_verse->firstItem(),
                "to" => $bible_verse->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($bible_verse->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Events(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $events = Event::select('id','event_name','date','venue','details','image')
                            ->where('status',1);

            if($request['search_word']){
                $events->where('event_name','like',$request['search_word'].'%')
                        ->orwhere('venue','like',$request['search_word'].'%')
                        ->orwhere('details','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $events=$events->orderBy('id', 'desc')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($events)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $events->total(),
                "per_page" => $events->perPage(),
                "current_page" => $events->currentPage(),
                "last_page" => $events->lastPage(),
                "next_page_url" => $events->nextPageUrl(),
                "prev_page_url" => $events->previousPageUrl(),
                "from" => $events->firstItem(),
                "to" => $events->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($events->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function NewsAnnouncements(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $NewsAnnouncement = NewsAnnouncement::select('id','type','heading','body','image')
                            ->where('status',1);

            if($request['search_word']){
                $NewsAnnouncement->where('heading','like',$request['search_word'].'%')
                                ->orwhere('body','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $NewsAnnouncement=$NewsAnnouncement->orderBy('id', 'desc')
                                    ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($NewsAnnouncement)) {
                $return['result']=  "Empty marital status list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $NewsAnnouncement->total(),
                "per_page" => $NewsAnnouncement->perPage(),
                "current_page" => $NewsAnnouncement->currentPage(),
                "last_page" => $NewsAnnouncement->lastPage(),
                "next_page_url" => $NewsAnnouncement->nextPageUrl(),
                "prev_page_url" => $NewsAnnouncement->previousPageUrl(),
                "from" => $NewsAnnouncement->firstItem(),
                "to" => $NewsAnnouncement->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($NewsAnnouncement->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Notifications(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $notification = Notification::select('id','title','content','type')
                            ->where('status',1);

            if($request['search_word']){
                $notification->where('title','like',$request['search_word'].'%')
                            ->orwhere('content','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $notification=$notification->orderBy('id', 'desc')
                                ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($notification)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $notification->total(),
                "per_page" => $notification->perPage(),
                "current_page" => $notification->currentPage(),
                "last_page" => $notification->lastPage(),
                "next_page_url" => $notification->nextPageUrl(),
                "prev_page_url" => $notification->previousPageUrl(),
                "from" => $notification->firstItem(),
                "to" => $notification->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($notification->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Obituaries(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $obituaries = Obituary::select('*')->where('status',1);

            if($request['search_word']){
                $obituaries->where('name_of_member','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $obituaries=$obituaries->orderBy('id', 'desc')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($obituaries)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $obituaries->total(),
                "per_page" => $obituaries->perPage(),
                "current_page" => $obituaries->currentPage(),
                "last_page" => $obituaries->lastPage(),
                "next_page_url" => $obituaries->nextPageUrl(),
                "prev_page_url" => $obituaries->previousPageUrl(),
                "from" => $obituaries->firstItem(),
                "to" => $obituaries->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($obituaries->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Organizations(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $organizations=Organization::select('id','organization_name','coordinator','coordinator_phone_number')
                            ->where('status',1);

            if($request['search_word']){
                $organizations->where('organization_name','like',$request['search_word'].'%')
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

    public function VicarMessages(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $VicarMessages=VicarMessage::select('id','subject','message_body','image')
                            ->where('status',1);

            if($request['search_word']){
                $VicarMessages->where('subject','like',$request['search_word'].'%')
                            ->orwhere('message_body','like',$request['search_word'].'%');

            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $VicarMessages=$VicarMessages->orderBy('id', 'desc')
                                ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($VicarMessages)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $VicarMessages->total(),
                "per_page" => $VicarMessages->perPage(),
                "current_page" => $VicarMessages->currentPage(),
                "last_page" => $VicarMessages->lastPage(),
                "next_page_url" => $VicarMessages->nextPageUrl(),
                "prev_page_url" => $VicarMessages->previousPageUrl(),
                "from" => $VicarMessages->firstItem(),
                "to" => $VicarMessages->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($VicarMessages->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }


    public function Directory(Request $request){

        try {

            $per_pg='';
            $family_pg_no='';
            $member_pg_no='';
            $prayer_group_pg_no='';
            $organization_pg_no='';

            /*---------Family Details----------*/

                $families = Family::select('*')->where('status',1);
                if($request['search_word']){

                    $families->where(function ($query) use ($request) {
                        $query->where('family_name', 'like', $request['search_word'].'%')
                            ->orWhere('family_code', 'like', $request['search_word'].'%');
                    })
                    ->orwhereHas('members', function ($query) use ($request) {
                        $query->where('name', 'like', $request['search_word'].'%')
                              ->where('head_of_family', 1);
                    });
                }
                if($request['family_page_no']){
                    $family_pg_no=$request['family_page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $families=$families->orderBy('family_name','asc')
                    ->paginate($perPage=$per_pg,[],'',$page =$family_pg_no);

                if(empty($families)) {
                    $return['result']=  "Empty family list ";
                    return $this->outputer->code(422)->error($return)->json();
                }
                $family_metadata = array(
                    "total" => $families->total(),
                    "per_page" => $families->perPage(),
                    "current_page" => $families->currentPage(),
                    "last_page" => $families->lastPage(),
                    "next_page_url" => $families->nextPageUrl(),
                    "prev_page_url" => $families->previousPageUrl(),
                    "from" => $families->firstItem(),
                    "to" => $families->lastItem()
                );

            /*---------Members Details----------*/

                $members = FamilyMember::select('*')->where('status',1);
                if($request['search_word']){

                    $members->where(function ($query) use ($request) {
                        $query->where('name', 'like', $request['search_word'].'%')
                            ->orWhere('nickname', 'like', $request['search_word'].'%');
                    })
                    ->orwhereHas('BloodGroup', function ($query) use ($request) {
                        $query->where('blood_group_name', 'like', $request['search_word'].'%');
                    });
                }
                if($request['member_page_no']){
                    $member_pg_no=$request['member_page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $members=$members->orderBy('name', 'asc')->paginate($perPage=$per_pg,[],'',$page =$member_pg_no);

                if(empty($members)) {
                    $return['result']=  "Empty bible verse list ";
                    return $this->outputer->code(422)->error($return)->json();
                }
                $members_metadata = array(
                    "total" => $members->total(),
                    "per_page" => $members->perPage(),
                    "current_page" => $members->currentPage(),
                    "last_page" => $members->lastPage(),
                    "next_page_url" => $members->nextPageUrl(),
                    "prev_page_url" => $members->previousPageUrl(),
                    "from" => $members->firstItem(),
                    "to" => $members->lastItem()
                );

            /*---------Prayer Group Details----------*/

                $prayer_group = PrayerGroup::select('id','group_name','leader','leader_phone_number')
                                ->where('status',1);
                if($request['search_word']){
                    $prayer_group->where('group_name','like',$request['search_word'].'%')
                                ->orwhere('leader','like',$request['search_word'].'%');
                }
                if($request['prayer_group_page_no']){
                    $prayer_group_pg_no=$request['prayer_group_page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $prayer_group=$prayer_group->paginate($perPage=$per_pg,[],'',$page = $prayer_group_pg_no);

                if(empty($prayer_group)) {
                    $return['result']=  "Empty prayer group list ";
                    return $this->outputer->code(422)->error($return)->json();
                }
                $prayer_group_metadata = array(
                    "total" => $prayer_group->total(),
                    "per_page" => $prayer_group->perPage(),
                    "current_page" => $prayer_group->currentPage(),
                    "last_page" => $prayer_group->lastPage(),
                    "next_page_url" => $prayer_group->nextPageUrl(),
                    "prev_page_url" => $prayer_group->previousPageUrl(),
                    "from" => $prayer_group->firstItem(),
                    "to" => $prayer_group->lastItem()
                );

            /*---------Organizations Details----------*/

                $organizations=Organization::select('id','organization_name','coordinator','coordinator_phone_number')
                        ->where('status',1);
                if($request['search_word']){
                    $organizations->where('organization_name','like',$request['search_word'].'%')
                                ->orwhere('coordinator','like',$request['search_word'].'%');

                }
                if($request['organization_page_no']){
                    $organization_pg_no=$page=$request['organization_page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $organizations=$organizations->orderBy('id', 'desc')
                                    ->paginate($perPage=$per_pg,[],'',$page = $organization_pg_no);

                if(empty($organizations)) {
                    $return['result']=  "Empty prayer group list ";
                    return $this->outputer->code(422)->error($return)->json();
                }
                $organization_metadata = array(
                    "total" => $organizations->total(),
                    "per_page" => $organizations->perPage(),
                    "current_page" => $organizations->currentPage(),
                    "last_page" => $organizations->lastPage(),
                    "next_page_url" => $organizations->nextPageUrl(),
                    "prev_page_url" => $organizations->previousPageUrl(),
                    "from" => $organizations->firstItem(),
                    "to" => $organizations->lastItem()
                );


            $mergedData = [
                'families' => $families->getCollection(),
                'members' => $members->getCollection(),
                'prayer_group' => $prayer_group->getCollection(),
                'organizations' => $organizations->getCollection(),
            ];

            $metadata = [
                'family_metadata' => $family_metadata,
                'members_metadata' => $members_metadata,
                'prayer_group_metadata' => $prayer_group_metadata,
                'organization_metadata' => $organization_metadata,
            ];

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($mergedData)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

}
