<?php

namespace App\Http\Controllers\Api;

use DB;
use Mail;
use Auth;
use Cache;
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
use App\Models\Download;
use App\Models\PaymentDetail;
use App\Models\MemoryDay;
use App\Models\BiblicalCitation;
use App\Models\DailySchedules;

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

    // public function BibleVerses(Request $request){

    //     try {

    //         $pg_no='';
    //         $per_pg='';

    //         $bible_verse = BibleVerse::select('id','ref','verse')->where('status',1);

    //         if($request['search_word']){
    //             $bible_verse->where('ref','like',$request['search_word'].'%')
    //                         ->orwhere('verse','like',$request['search_word'].'%');
    //         }
    //         if($request['page_no']){
    //             $pg_no=$page=$request['page_no'];
    //         }
    //         if($request['per_page']){
    //            $per_pg=$page=$request['per_page'];
    //         }
    //         $bible_verse=$bible_verse->orderBy('id', 'desc')->paginate($perPage=$per_pg,[],'',$page =$pg_no);

    //         if(empty($bible_verse)) {
    //             $return['result']=  "Empty bible verse list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $metadata = array(
    //             "total" => $bible_verse->total(),
    //             "per_page" => $bible_verse->perPage(),
    //             "current_page" => $bible_verse->currentPage(),
    //             "last_page" => $bible_verse->lastPage(),
    //             "next_page_url" => $bible_verse->nextPageUrl(),
    //             "prev_page_url" => $bible_verse->previousPageUrl(),
    //             "from" => $bible_verse->firstItem(),
    //             "to" => $bible_verse->lastItem()
    //         );

    //         return $this->outputer->code(200)->metadata($metadata)
    //                     ->success($bible_verse->getCollection())->json();

    //     }catch (\Exception $e) {

    //         $return['result']=$e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    // public function Events(Request $request){

    //     try {

    //         $pg_no='';
    //         $per_pg='';

    //         $events = Event::select('id','event_name','date','venue','details','image')
    //                         ->where('status',1);

    //         if($request['search_word']){
    //             $events->where('event_name','like',$request['search_word'].'%')
    //                     ->orwhere('venue','like',$request['search_word'].'%')
    //                     ->orwhere('details','like',$request['search_word'].'%');
    //         }
    //         if($request['page_no']){
    //             $pg_no=$page=$request['page_no'];
    //         }
    //         if($request['per_page']){
    //            $per_pg=$page=$request['per_page'];
    //         }
    //         $events=$events->orderBy('id', 'desc')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

    //         if(empty($events)) {
    //             $return['result']=  "Empty prayer group list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $metadata = array(
    //             "total" => $events->total(),
    //             "per_page" => $events->perPage(),
    //             "current_page" => $events->currentPage(),
    //             "last_page" => $events->lastPage(),
    //             "next_page_url" => $events->nextPageUrl(),
    //             "prev_page_url" => $events->previousPageUrl(),
    //             "from" => $events->firstItem(),
    //             "to" => $events->lastItem()
    //         );

    //         return $this->outputer->code(200)->metadata($metadata)
    //                     ->success($events->getCollection())->json();

    //     }catch (\Exception $e) {

    //         $return['result']=$e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    // public function NewsAnnouncements(Request $request){

    //     try {

    //         $pg_no='';
    //         $per_pg='';

    //         $NewsAnnouncement = NewsAnnouncement::select('id','type','heading','body','image')
    //                         ->where('status',1);

    //         if($request['search_word']){
    //             $NewsAnnouncement->where('heading','like',$request['search_word'].'%')
    //                             ->orwhere('body','like',$request['search_word'].'%');
    //         }
    //         if($request['page_no']){
    //             $pg_no=$page=$request['page_no'];
    //         }
    //         if($request['per_page']){
    //            $per_pg=$page=$request['per_page'];
    //         }
    //         $NewsAnnouncement=$NewsAnnouncement->orderBy('id', 'desc')
    //                                 ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

    //         if(empty($NewsAnnouncement)) {
    //             $return['result']=  "Empty marital status list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $metadata = array(
    //             "total" => $NewsAnnouncement->total(),
    //             "per_page" => $NewsAnnouncement->perPage(),
    //             "current_page" => $NewsAnnouncement->currentPage(),
    //             "last_page" => $NewsAnnouncement->lastPage(),
    //             "next_page_url" => $NewsAnnouncement->nextPageUrl(),
    //             "prev_page_url" => $NewsAnnouncement->previousPageUrl(),
    //             "from" => $NewsAnnouncement->firstItem(),
    //             "to" => $NewsAnnouncement->lastItem()
    //         );

    //         return $this->outputer->code(200)->metadata($metadata)
    //                     ->success($NewsAnnouncement->getCollection())->json();

    //     }catch (\Exception $e) {

    //         $return['result']=$e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    // public function Obituaries(Request $request){

    //     try {

    //         $pg_no='';
    //         $per_pg='';

    //         $obituaries = Obituary::select('*')->where('status',1);

    //         if($request['search_word']){
    //             $obituaries->where('name_of_member','like',$request['search_word'].'%');
    //         }
    //         if($request['page_no']){
    //             $pg_no=$page=$request['page_no'];
    //         }
    //         if($request['per_page']){
    //            $per_pg=$page=$request['per_page'];
    //         }
    //         $obituaries=$obituaries->orderBy('id', 'desc')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

    //         if(empty($obituaries)) {
    //             $return['result']=  "Empty prayer group list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $metadata = array(
    //             "total" => $obituaries->total(),
    //             "per_page" => $obituaries->perPage(),
    //             "current_page" => $obituaries->currentPage(),
    //             "last_page" => $obituaries->lastPage(),
    //             "next_page_url" => $obituaries->nextPageUrl(),
    //             "prev_page_url" => $obituaries->previousPageUrl(),
    //             "from" => $obituaries->firstItem(),
    //             "to" => $obituaries->lastItem()
    //         );

    //         return $this->outputer->code(200)->metadata($metadata)
    //                     ->success($obituaries->getCollection())->json();

    //     }catch (\Exception $e) {

    //         $return['result']=$e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    public function Notifications(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $notification = Notification::select('id','title','content','type','group_org_id')
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

            $VicarMessages->getCollection()->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

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

                $families = Family::select('id as id','family_name as item')
                        ->addSelect(DB::raw('(SELECT name FROM family_members WHERE families.id = family_members.family_id AND head_of_family = 1 LIMIT 1) AS sub_item')
                            ,DB::raw('"null" as image'),DB::raw('"Families" as type'))
                        ->where('status',1);
                if($request['search_word']){

                    $families->where(function ($query) use ($request) {
                        $query->where('family_name', 'like', $request['search_word'].'%')
                            ->orWhere('family_code', 'like', $request['search_word'].'%');
                    });
                    // ->orwhereHas('members', function ($query) use ($request) {
                    //    $query->where('name', 'like', $request['search_word'].'%')
                    //           ->where('head_of_family', 1);
                    // });
                }

                // if($request['family_page_no']){
                //     $family_pg_no=$request['family_page_no'];
                // }
                // if($request['per_page']){
                //    $per_pg=$page=$request['per_page'];
                // }

                $families=$families->orderBy('family_name','asc')
                    //->paginate($perPage=$per_pg,[],'',$page =$family_pg_no);
                    ->get();

                if(empty($families)) {
                    $return['result']=  "Empty family list ";
                    return $this->outputer->code(422)->error($return)->json();
                }
                // $family_metadata = array(
                //     "total" => $families->total(),
                //     "per_page" => $families->perPage(),
                //     "current_page" => $families->currentPage(),
                //     "last_page" => $families->lastPage(),
                //     "next_page_url" => $families->nextPageUrl(),
                //     "prev_page_url" => $families->previousPageUrl(),
                //     "from" => $families->firstItem(),
                //     "to" => $families->lastItem()
                // );


            /*---------Members Details----------*/

                $members = FamilyMember::select('id as id','name as item')
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_item'),'image',DB::raw('"Members" as type'))
                        ->addSelect('family_id')
                        ->where('status',1);
                if($request['search_word']){

                    $members->where(function ($query) use ($request) {
                        $query->where('name', 'like', $request['search_word'].'%')
                            ->orWhere('nickname', 'like', $request['search_word'].'%');
                    });
                    // ->orwhereHas('BloodGroup', function ($query) use ($request) {
                    //     $query->where('blood_group_name', 'like', $request['search_word'].'%');
                    // });
                }
                // if($request['member_page_no']){
                //     $member_pg_no=$request['member_page_no'];
                // }
                // if($request['per_page']){
                //    $per_pg=$page=$request['per_page'];
                // }
                $members=$members->orderBy('name', 'asc')
                //->paginate($perPage=$per_pg,[],'',$page =$member_pg_no);
                ->get();

                if(empty($members)) {
                    $return['result']=  "Empty bible verse list ";
                    return $this->outputer->code(422)->error($return)->json();
                }
                $members->transform(function ($item, $key) {

                    if ($item->image !== null) {
                         $item->image = asset('/') . $item->image;
                    }
                    return $item;
                });
                // $members_metadata = array(
                //     "total" => $members->total(),
                //     "per_page" => $members->perPage(),
                //     "current_page" => $members->currentPage(),
                //     "last_page" => $members->lastPage(),
                //     "next_page_url" => $members->nextPageUrl(),
                //     "prev_page_url" => $members->previousPageUrl(),
                //     "from" => $members->firstItem(),
                //     "to" => $members->lastItem()
                // );

            /*---------Prayer Group Details----------*/

                $prayer_group = PrayerGroup::select('id as id','group_name as item','leader as sub_item',
                    DB::raw('"null" as image'),DB::raw('"Prayer Groups" as type'))
                                ->where('status',1);
                if($request['search_word']){
                    $prayer_group->where('group_name','like',$request['search_word'].'%');
                                //->orwhere('leader','like',$request['search_word'].'%');
                }
                // if($request['prayer_group_page_no']){
                //     $prayer_group_pg_no=$request['prayer_group_page_no'];
                // }
                // if($request['per_page']){
                //    $per_pg=$page=$request['per_page'];
                // }
                $prayer_group=$prayer_group
                //->paginate($perPage=$per_pg,[],'',$page = $prayer_group_pg_no);
                ->get();

                if(empty($prayer_group)) {
                    $return['result']=  "Empty prayer group list ";
                    return $this->outputer->code(422)->error($return)->json();
                }
                // $prayer_group_metadata = array(
                //     "total" => $prayer_group->total(),
                //     "per_page" => $prayer_group->perPage(),
                //     "current_page" => $prayer_group->currentPage(),
                //     "last_page" => $prayer_group->lastPage(),
                //     "next_page_url" => $prayer_group->nextPageUrl(),
                //     "prev_page_url" => $prayer_group->previousPageUrl(),
                //     "from" => $prayer_group->firstItem(),
                //     "to" => $prayer_group->lastItem()
                // );

            /*---------Organizations Details----------*/

                // $organizations=Organization::select('id as id','organization_name as item','coordinator as sub_item',DB::raw('"null" as image'),DB::raw('"Organizations" as type'))
                //         ->where('status',1);

                $organizations=FamilyMember::select(DB::raw('"1" as id'),'company_name as item',
                    DB::raw('CONCAT("No. of employees: ", COUNT(*)) as sub_item'),
                    DB::raw('"null" as image'),
                    DB::raw('"Organizations" as type'))
                    ->groupBy('company_name')
                    ->whereNotNull('company_name') 
                    ->where('status',1);

                if($request['search_word']){
                    //$organizations->where('organization_name','like',$request['search_word'].'%');
                    $organizations->where('company_name','like',$request['search_word'].'%');
                }
                // if($request['organization_page_no']){
                //     $organization_pg_no=$page=$request['organization_page_no'];
                // }
                // if($request['per_page']){
                //    $per_pg=$page=$request['per_page'];
                // }
                $organizations=$organizations->orderBy('id', 'desc')
                        //->paginate($perPage=$per_pg,[],'',$page = $organization_pg_no);
                        ->get();

                if(empty($organizations)) {
                    $return['result']=  "Empty prayer group list ";
                    return $this->outputer->code(422)->error($return)->json();
                }


                // $organization_metadata = array(
                //     "total" => $organizations->total(),
                //     "per_page" => $organizations->perPage(),
                //     "current_page" => $organizations->currentPage(),
                //     "last_page" => $organizations->lastPage(),
                //     "next_page_url" => $organizations->nextPageUrl(),
                //     "prev_page_url" => $organizations->previousPageUrl(),
                //     "from" => $organizations->firstItem(),
                //     "to" => $organizations->lastItem()
                // );

                $organizations->transform(function ($item) {
                    $item->setAppends([]);
                    $item->setRelations([]);
                    return $item;
                });
            /*---------type 1 result----------*/

            // $mergedData = [
            //     'families' => $families->getCollection(),
            //     'members' => $members->getCollection(),
            //     'prayer_group' => $prayer_group->getCollection(),
            //     'organizations' => $organizations->getCollection(),
            // ];


            /*---------type 2 result----------*/

            // $familyData = [
            //     'category' => 'family',
            //     'list' => $families->getCollection()
            // ];
            // $memberData = [
            //     'category' => 'member',
            //     'list' => $members->getCollection()
            // ];
            // $prayer_groupData = [
            //     'category' => 'prayer_group',
            //     'list' => $prayer_group->getCollection()
            // ];
            // $organizationsData = [
            //     'category' => 'organizations',
            //     'list' => $organizations->getCollection()
            // ];

            // $mergedData = [
            //     'families' => $familyData,
            //     'members' => $memberData,
            //     'prayer_group' => $prayer_groupData,
            //     'organizations' => $organizationsData,
            // ];


            /*---------type 3 result----------*/


            if ($request['search_word']) {
                // $search_results = $families->getCollection()
                //     ->merge($members->getCollection())
                //     ->merge($prayer_group->getCollection())
                //     ->merge($organizations->getCollection());
                $search_results = $families
                    ->merge($members)
                    ->merge($prayer_group)
                    ->merge($organizations);


                $search_results_metadata = [
                    "total" => $search_results->count(),
                ];
            }

            // $mergedData = [

            //     [ 'category' => 'Families', 'list' => $families->getCollection() ],

            //     [ 'category' => 'Members', 'list' => $members->getCollection() ],

            //     [ 'category' => 'Prayer Groups', 'list' => $prayer_group->getCollection() ],

            //     [ 'category' => 'Organizations', 'list' => $organizations->getCollection() ],

               
            // ];

            // if ($request['search_word']) {
            //     $mergedData[] = ['category' => 'Search Results', 'list' => $search_results];

            // }

            // $metadata = [
            //     'family_metadata' => $family_metadata,
            //     'members_metadata' => $members_metadata,
            //     'prayer_group_metadata' => $prayer_group_metadata,
            //     'organization_metadata' => $organization_metadata,
            // ];
            // if ($request['search_word']) {
            //     $metadata['search_results_metadata'] = $search_results_metadata;

            // }


                    // Prepare merged data and metadata
        $mergedData = [];
        $metadata = [];

        if ($request['search_word']) {
             $mergedData[] = ['category' => 'Search Results', 'list' => $search_results];
            //$metadata['search_results_metadata'] = $search_results_metadata;
        }

        $mergedData[] = ['category' => 'Families', 'list' => $families];
        //$metadata['family_metadata'] = $family_metadata;

        $mergedData[] = ['category' => 'Members', 'list' => $members];
        //$metadata['members_metadata'] = $members_metadata;

        $mergedData[] = ['category' => 'Prayer Groups', 'list' => $prayer_group];
        //$metadata['prayer_group_metadata'] = $prayer_group_metadata;

        $mergedData[] = ['category' => 'Organizations', 'list' => $organizations];
        //$metadata['organization_metadata'] = $organization_metadata;

            return $this->outputer->code(200)
                        //->metadata($metadata)
                        ->success($mergedData)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function DailyDigest(Request $request){
        try {

            $per_pg='';
            $pg_no='';

            $today= now();
            $day = $today->format('d');
            $month = $today->format('m');
            $monthDay = $today->format('m-d');
            $today_string = now()->toDateString();

            $todayFormatted = date('d/m/Y');


            if($request['date']){
                $today=$page=$request['date'];
            }

            /*---------Daily Bible verse----------*/

            $bible_verse = BibleVerse::select('id','verse as heading','ref as sub_heading')
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1)->first();
            if (!$bible_verse) {
                $random_verse = BibleVerse::select('id', 'verse as heading', 'ref as sub_heading')
                        ->where('status', 1)
                        ->inRandomOrder()
                        ->first();
    
                $bible_verse = $random_verse ?? ['id' => null, 'heading' => 'Default Heading', 'sub_heading' => 'Default Subheading'];
            }

            /*---------Daily Schedules Details----------*/

            $memoryData = MemoryDay::select('id',DB::raw('"ഓർമ" as heading'), 'title as sub_heading', 
                DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'), 
                DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'))
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1)->take(2); 

            $bibleCitationData = BiblicalCitation::select('id',DB::raw('"വേദഭാഗങ്ങൾ" as heading'), 'reference as sub_heading',
              DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),
               DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'))
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1)->take(1); 


            $church_activities = DailySchedules::select('id',DB::raw('"പള്ളി പ്രവർത്തനങ്ങൾ" as heading'),'details as sub_heading', DB::raw('IFNULL(DATE_FORMAT(date, "%d/%m/%Y"), "' . $todayFormatted . '") as date'), 
                 DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"False" as color'), DB::raw('"null" as link'))
                ->whereDate('date',$today_string)
                ->where('status', 1)->take(1); 
            if ($church_activities->count() == 0) {

                $todayDayValue = date("N");

                $church_activities = DailySchedules::select('id',DB::raw('"പള്ളി പ്രവർത്തനങ്ങൾ" as heading'),'details as sub_heading',
                    DB::raw('IFNULL(DATE_FORMAT(date, "%d/%m/%Y"), "' . $todayFormatted . '") as date'),
                    DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"False" as color'), DB::raw('"null" as link'))
                        ->where('status', 1)->take(1); 

                if ($todayDayValue == 7) { 
                       $church_activities = $church_activities->where('day_category', 2); 
                } else {
                    $church_activities = $church_activities->where('day_category', 1); 
                }

            }

            $churchActivitiesData = $church_activities;

            $daily_schedules = $memoryData->union($bibleCitationData)
                                ->union($churchActivitiesData)
                                ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            $daily_schedules->getCollection()->transform(function ($item, $key) {

                if ($item->image !== 'null') {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            $daiy_schedules_metadata = array(
                "total" => $daily_schedules->total(),
                "per_page" => $daily_schedules->perPage(),
                "current_page" => $daily_schedules->currentPage(),
                "last_page" => $daily_schedules->lastPage(),
                "next_page_url" => $daily_schedules->nextPageUrl(),
                "prev_page_url" => $daily_schedules->previousPageUrl(),
                "from" => $daily_schedules->firstItem(),
                "to" => $daily_schedules->lastItem()
            );

            /*---------Birthdays Details----------*/

            $birthdays = FamilyMember::select('id','name as heading')
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_heading'))
                        ->addSelect('dob as date','image',DB::raw('"Birthdays" as type'),DB::raw('"False" as color'),'family_id', DB::raw('"null" as link'))
                        ->whereMonth('dob', '=', $month)
                        ->whereDay('dob', '>=', $day)
                        ->where('status',1);

            if($request['search_word']){
                $birthdays->where('title','like',$request['search_word'].'%')
                            ->orwhere('content','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $birthdays=$birthdays->orderByRaw('DAY(dob)')
                                ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            $birthdays->getCollection()->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            if(empty($birthdays)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $birthdays_metadata = array(
                "total" => $birthdays->total(),
                "per_page" => $birthdays->perPage(),
                "current_page" => $birthdays->currentPage(),
                "last_page" => $birthdays->lastPage(),
                "next_page_url" => $birthdays->nextPageUrl(),
                "prev_page_url" => $birthdays->previousPageUrl(),
                "from" => $birthdays->firstItem(),
                "to" => $birthdays->lastItem()
            );

             /*---------Vicar Messages----------*/

            $Vic_messages = VicarMessage::select('id','subject as heading','message_body as sub_heading',
                           DB::raw('DATE_FORMAT(NOW(), "%d/%m/%Y") as date'))
                        ->addSelect('image',DB::raw('"Vicar Messages" as type'),DB::raw('"False" as color'),
                         DB::raw('"null" as link'))
                        ->where('status',1);

            if($request['search_word']){
                $Vic_messages->where('subject','like',$request['search_word'].'%')
                            ->orwhere('message_body','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $Vic_messages=$Vic_messages->orderBy('updated_at','desc')
                                ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            $Vic_messages->getCollection()->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            if(empty($Vic_messages)) {
                $return['result']=  "Empty messages list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $Vic_messages_metadata = array(
                "total" => $Vic_messages->total(),
                "per_page" => $Vic_messages->perPage(),
                "current_page" => $Vic_messages->currentPage(),
                "last_page" => $Vic_messages->lastPage(),
                "next_page_url" => $Vic_messages->nextPageUrl(),
                "prev_page_url" => $Vic_messages->previousPageUrl(),
                "from" => $Vic_messages->firstItem(),
                "to" => $Vic_messages->lastItem()
            );

            /*---------Obituaries Details----------*/


            $obituary = Obituary::select('id','name_of_member as heading')
                        ->selectSub(function ($query) {
                            $query->select('families.family_name')
                                ->from('family_members')
                                ->join('families', 'family_members.family_id', '=', 'families.id')
                                ->whereColumn('family_members.id', 'obituaries.member_id')
                                ->limit(1);
                        }, 'sub_heading')
                        ->addSelect('date_of_death as date','photo as image',DB::raw('"Obituaries" as type'),DB::raw('"False" as color'),'member_id', DB::raw('"null" as link'),'display_till_date')
                        //->whereMonth('date_of_death', '=', $month)
                        //->whereDay('date_of_death', '>=', $day)
                        ->whereRaw("DATE_FORMAT(date_of_death, '%m-%d-%Y') = DATE_FORMAT('$today_string', '%m-%d-%Y')")
                        ->where('status',1);

            if($request['search_word']){
                $obituary->where('subject','like',$request['search_word'].'%')
                            ->orwhere('message_body','like',$request['search_word'].'%');

            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $obituary=$obituary->orderByRaw('DAY(date_of_death)')
                                ->paginate($perPage=$per_pg,[],'',$page = $pg_no);
            $obituary->getCollection()->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            if(empty($obituary)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $obituary_metadata = array(
                "total" => $obituary->total(),
                "per_page" => $obituary->perPage(),
                "current_page" => $obituary->currentPage(),
                "last_page" => $obituary->lastPage(),
                "next_page_url" => $obituary->nextPageUrl(),
                "prev_page_url" => $obituary->previousPageUrl(),
                "from" => $obituary->firstItem(),
                "to" => $obituary->lastItem()
            );

            $mergedData = [

                [ 'category' => 'Daily Schedules', 'list' => $daily_schedules->getCollection() ],

                [ 'category' => 'Vicar Messages', 'list' => $Vic_messages->getCollection() ],

                [ 'category' => 'Obituary', 'list' => $obituary->getCollection() ],
               
            ];

            $metadata = [
                'daiy_schedules_metadata' => $daiy_schedules_metadata,
                'Vic_messages_metadata' => $Vic_messages_metadata,
                'obituary_metadata' => $obituary_metadata,
            ];

            return $this->outputer->code(200)
                        ->metadata($metadata)
                        ->success($mergedData )
                        ->DailyDigest($bible_verse)
                        ->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Bulletin(Request $request){

        try {

            $per_pg='';
            $pg_no='';

            /*---------Events Details----------*/

            $events = Event::select('id','date','event_name as item','venue as sub_item','details','image',
                DB::raw('"Events" as type_value'),DB::raw('"False" as color'),DB::raw('"Events" as hash_value'),
                'link')
                ->where('status',1);
            if($request['search_word']){
                $events->where('event_name','like',$request['search_word'].'%')
                        ->orwhere('venue','like',$request['search_word'].'%')
                        ->orwhere('details','like',$request['search_word'].'%');
            }
            // if($request['page_no']){
            //     $pg_no=$request['page_no'];
            // }
            // if($request['per_page']){
            //    $per_pg=$request['per_page'];
            // }
            $events=$events->orderBy('id', 'desc')
                //->paginate($perPage=$per_pg,[],'',$page = $pg_no);
                ->get();

            if(empty($events)) {
                $return['result']=  "Empty events list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $events->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            // $events_metadata = array(
            //     "total" => $events->total(),
            //     "per_page" => $events->perPage(),
            //     "current_page" => $events->currentPage(),
            //     "last_page" => $events->lastPage(),
            //     "next_page_url" => $events->nextPageUrl(),
            //     "prev_page_url" => $events->previousPageUrl(),
            //     "from" => $events->firstItem(),
            //     "to" => $events->lastItem()
            // );

            /*---------News & Announcements Details----------*/

            $newsAnnouncements = NewsAnnouncement::select('id','updated_at as date','heading as item')
            ->addSelect(DB::raw("
                CASE
                    WHEN type = 1 THEN 'Trustee'
                    WHEN type = 2 THEN 'Secretary'
                    WHEN type = 3 THEN 'Prayer Group'
                    ELSE 'Organization'
                END AS sub_item
            "))
            ->addSelect('body as details','image','type' ,'group_org_id',
                DB::raw('"News & Announcements" as type_value'),DB::raw('"False" as color'))
            ->addSelect(DB::raw("
                CASE
                    WHEN type = 1 THEN 'Trustee'
                    WHEN type = 2 THEN 'Secretary'
                    WHEN type = 3 THEN 'Prayer Group'
                    ELSE 'Organization'
                END AS hash_value
            "),'link')
            ->where('status',1);
            if($request['search_word']){
                $newsAnnouncements->where('heading','like',$request['search_word'].'%')
                                ->orwhere('body','like',$request['search_word'].'%');
            }
            // if($request['page_no']){
            //     $pg_no=$page=$request['page_no'];
            // }
            // if($request['per_page']){
            //    $per_pg=$page=$request['per_page'];
            // }
            $newsAnnouncements=$newsAnnouncements->orderBy('id', 'desc')
                                   // ->paginate($perPage=$per_pg,[],'',$page = $pg_no);
                                ->get();

            if(empty($newsAnnouncements)) {
                $return['result']=  "Empty marital status list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $newsAnnouncements->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            // $newsAnnouncements_metadata = array(
            //     "total" => $newsAnnouncements->total(),
            //     "per_page" => $newsAnnouncements->perPage(),
            //     "current_page" => $newsAnnouncements->currentPage(),
            //     "last_page" => $newsAnnouncements->lastPage(),
            //     "next_page_url" => $newsAnnouncements->nextPageUrl(),
            //     "prev_page_url" => $newsAnnouncements->previousPageUrl(),
            //     "from" => $newsAnnouncements->firstItem(),
            //     "to" => $newsAnnouncements->lastItem()
            // );

            /*---------Notifications Details----------*/

            $notifications = Notification::select('id','updated_at as date','title as item')
            ->addSelect(DB::raw("
                CASE
                    WHEN type = 1 THEN 'Trustee'
                    WHEN type = 2 THEN 'Secretary'
                    WHEN type = 3 THEN 'Prayer Group'
                    ELSE 'Organization'
                END AS sub_item
            "))
            ->addSelect('content as details','group_org_id','type',
                DB::raw('"Notifications" as type_value'),DB::raw('"False" as color'))
            ->addSelect(DB::raw("
                CASE
                    WHEN type = 1 THEN 'Trustee'
                    WHEN type = 2 THEN 'Secretary'
                    WHEN type = 3 THEN 'Prayer Group'
                    ELSE 'Organization'
                END AS hash_value
            "),DB::raw('"null" as link'))
            ->where('status',1);

            if($request['search_word']){
                $notifications->where('title','like',$request['search_word'].'%')
                            ->orwhere('content','like',$request['search_word'].'%');
            }
            // if($request['page_no']){
            //     $pg_no=$page=$request['page_no'];
            // }
            // if($request['per_page']){
            //    $per_pg=$page=$request['per_page'];
            // }
            $notifications=$notifications->orderBy('id', 'desc')
                                //->paginate($perPage=$per_pg,[],'',$page = $pg_no);
                            ->get();

            $notifications->transform(function ($notif) {
                $notif->image = null;
                return $notif;
            });
            if(empty($notifications)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            // $notifications_metadata = array(
            //     "total" => $notifications->total(),
            //     "per_page" => $notifications->perPage(),
            //     "current_page" => $notifications->currentPage(),
            //     "last_page" => $notifications->lastPage(),
            //     "next_page_url" => $notifications->nextPageUrl(),
            //     "prev_page_url" => $notifications->previousPageUrl(),
            //     "from" => $notifications->firstItem(),
            //     "to" => $notifications->lastItem()
            // );

            /*---------Obituaries Details----------*/

            $obituaries = Obituary::select('id','date_of_death as date','name_of_member as item')
                ->selectSub(function ($query) {
                    $query->select('families.family_name')
                        ->from('family_members')
                        ->join('families', 'family_members.family_id', '=', 'families.id')
                        ->whereColumn('family_members.id', 'obituaries.member_id')
                        ->limit(1);
                }, 'sub_item')
            ->addSelect('notes as details','photo as image',
                DB::raw('"Obituaries" as type_value'),DB::raw('"False" as color'))
            ->where('status',1);

            if($request['search_word']){
                $obituaries->where('name_of_member','like',$request['search_word'].'%');
            }
            // if($request['page_no']){
            //     $pg_no=$page=$request['page_no'];
            // }
            // if($request['per_page']){
            //    $per_pg=$page=$request['per_page'];
            // }
            $obituaries=$obituaries->orderBy('id', 'desc')
                //->paginate($perPage=$per_pg,[],'',$page = $pg_no);
                ->get();

            if(empty($obituaries)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $obituaries->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            // $obituaries_metadata = array(
            //     "total" => $obituaries->total(),
            //     "per_page" => $obituaries->perPage(),
            //     "current_page" => $obituaries->currentPage(),
            //     "last_page" => $obituaries->lastPage(),
            //     "next_page_url" => $obituaries->nextPageUrl(),
            //     "prev_page_url" => $obituaries->previousPageUrl(),
            //     "from" => $obituaries->firstItem(),
            //     "to" => $obituaries->lastItem()
            // );

            if ($request['search_word']) {
                $search_results = $events
                    ->merge($newsAnnouncements)
                    ->merge($notifications)
                    ->merge($VicarMessages);


                $search_results_metadata = [
                    "total" => $search_results->count(),
                ];
            }


            $mergedData = [];
            //$metadata = [];

            if ($request['search_word']) {
                $mergedData[] = ['category' => 'Search Results', 'list' => $search_results];
                //$metadata['search_results_metadata'] = $search_results_metadata;
            }

            $mergedData[] = ['category' => 'Events', 'list' => $events];
            //$metadata['events_metadata'] = $events_metadata;

            $mergedData[] = ['category' => 'News & Announcements', 'list' => $newsAnnouncements];
            //$metadata['newsAnnouncements_metadata'] = $newsAnnouncements_metadata;

            $mergedData[] = ['category' => 'Notifications', 'list' => $notifications];
            //$metadata['notifications_metadata'] = $notifications_metadata;

            //$mergedData[] = ['category' => 'Vicar Messages', 'list' => $VicarMessages];
            //$metadata['VicarMessages_metadata'] = $VicarMessages_metadata;

            return $this->outputer->code(200)
            //->metadata($metadata)
                        ->success($mergedData)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Downloads(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $downloads = Download::select('id','title','file','type','details',
                        DB::raw('DATE(created_at) as date' ))
                        ->where('status',1);

            if($request['search_word']){
                $downloads->where('title','like','%'.$request['search_word'].'%')
                        ->orwhere('type','like','%'.$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $downloads=$downloads->orderBy('title', 'desc')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($downloads)) {
                $return['result']=  "Empty downloads list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $downloads->getCollection()->transform(function ($item, $key) {
                $item->file = asset('/') . $item->file;
                return $item;
            });

            $metadata = array(
                "total" => $downloads->total(),
                "per_page" => $downloads->perPage(),
                "current_page" => $downloads->currentPage(),
                "last_page" => $downloads->lastPage(),
                "next_page_url" => $downloads->nextPageUrl(),
                "prev_page_url" => $downloads->previousPageUrl(),
                "from" => $downloads->firstItem(),
                "to" => $downloads->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($downloads->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Contributions(Request $request){

        try {

            $pg_no='';
            $per_pg='';
            $family_id = Auth::user()->family_id;
            $member_id = Auth::user()->id;


            $payments = PaymentDetail::select('payment_details.*')
                    ->join('family_members', 'payment_details.member_id', '=', 'family_members.id')
                    ->where('family_members.family_id', $family_id)
                    ->where('family_members.id', $member_id)
                    ->where('payment_details.status', 1);
            $payments_sum = $payments->sum('payment_details.amount');

            $family = Family::select('id','family_code','family_name')->find($family_id);

            $payments=$payments->orderBy('payment_details.date')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($payments)) {
                $return['result']=  "Empty payments list ";
                return $this->outputer->code(422)->error($return)->json();
            }
            
            $result['family'] = $family;
            $result['total'] = $payments_sum;
            $result['payments'] = $payments->getCollection();

            $metadata = array(
                "total" => $payments->total(),
                "per_page" => $payments->perPage(),
                "current_page" => $payments->currentPage(),
                "last_page" => $payments->lastPage(),
                "next_page_url" => $payments->nextPageUrl(),
                "prev_page_url" => $payments->previousPageUrl(),
                "from" => $payments->firstItem(),
                "to" => $payments->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)->success($result)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function YearlyCalenderEvents(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $year=date("Y");

            if($request['year']){
                $year = $request['year'];
            }

            $data = [];

            for ($month = 1; $month <= 12; $month++) {
                for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++) {
                    
                    $daily_readings = BiblicalCitation::select('id', 'reference', 'date')
                        ->whereMonth('date', $month)
                        ->whereDay('date', $day)
                        ->orderBy('date')
                        ->get();
                    $birthdays = FamilyMember::select('id', 'name', 'dob')
                        ->whereMonth('dob', $month)
                        ->whereDay('dob', $day)
                        ->orderBy('dob')
                        ->get();
                    $wedding_anniversaries = FamilyMember::select('id', 'name', 'date_of_marriage')
                        ->whereMonth('date_of_marriage', $month)
                        ->whereDay('date_of_marriage', $day)
                        ->orderBy('date_of_marriage')
                        ->get();

                    $obituaries = Obituary::select('id', 'member_id', 'name_of_member', 'date_of_death')
                        ->whereMonth('date_of_death', $month)
                        ->whereDay('date_of_death', $day)
                        ->orderBy('date_of_death')
                        ->get();
                    // $anniversary = MemoryDay::select('*')
                    //     ->whereMonth('date', $month)
                    //     ->whereDay('date', $day)
                    //     ->orderBy('date')
                    //     ->get();

                    // $date_results = [];
                    //     $birthdaysForDay = $birthdays->filter(function ($birthday) use ($day) {
                    //         return date('d', strtotime($birthday->dob)) == $day;
                    //     });
                    //     $bday_count = $birthdaysForDay->count();

                    //     $obituariesForDay = $obituaries->filter(function ($obituary) use ($day) {
                    //         return date('d', strtotime($obituary->date_of_death)) == $day;
                    //     });
                    //     $obituary_count = $birthdaysForDay->count();

                    //     $total_events = $bday_count + $obituary_count;

                    //     $date_results[] = [
                    //         'date' => sprintf('%02d-%02d-%02d', $day, $month, $year),
                    //         'total_events' => $total_events,
                    //         'birthday_events'=>$bday_count,
                    //         'death_anniversary_events'=>$obituary_count,
                    //     ];

                    $daily_readings_count = $daily_readings->count();
                    $bday_count = $birthdays->count();
                    $wedding_count = $wedding_anniversaries->count();
                    $obituary_count = $obituaries->count();
                    //$anniversary_count = $anniversary->count();
                    $total_events = $bday_count+$wedding_count+$daily_readings_count+$obituary_count;

                    $data[] = [
                        'date' => sprintf('%02d-%02d-%02d', $day, $month, $year),
                        'total_events' => $total_events,
                        'daily_readings' => $daily_readings_count,
                        'birthday_events' => $bday_count,
                        'wedding_anniversary_events' => $wedding_count,
                        'death_anniversary_events' => $obituary_count,
                    ];
                }

            }

            return $this->outputer->code(200)->success($data)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function DailyCalenderEvents(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $date=date("d-m-Y");
            if($request['date']){
                $date = $request['date'];
            }

            /*---------Daily reading Details----------*/

                $daily_readings = BiblicalCitation::select('id','reference as heading','note1 as sub_heading','date',
                    DB::raw('"null" as image'))
                                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                                ->where('status', 1)
                                ->orderBy('reference', 'asc');

                if($request['page_no']){
                    $pg_no=$page=$request['page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $daily_readings=$daily_readings->orderBy('id', 'desc')
                                    ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

                if(empty($daily_readings)) {
                    $return['result']=  "Empty daily_readings list ";
                    return $this->outputer->code(422)->error($return)->json();
                }

                $daily_readings_metadata = array(
                    "total" => $daily_readings->total(),
                    "per_page" => $daily_readings->perPage(),
                    "current_page" => $daily_readings->currentPage(),
                    "last_page" => $daily_readings->lastPage(),
                    "next_page_url" => $daily_readings->nextPageUrl(),
                    "prev_page_url" => $daily_readings->previousPageUrl(),
                    "from" => $daily_readings->firstItem(),
                    "to" => $daily_readings->lastItem()
                );

            /*---------Birthdays Details----------*/

                $birthdays = FamilyMember::select('id','name as heading')
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_heading'))
                        ->addSelect('dob as date','image as image','family_id')
                                ->whereRaw("DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                                ->where('status', 1)
                                ->orderBy('name', 'asc');

                if($request['page_no']){
                    $pg_no=$page=$request['page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $birthdays=$birthdays->orderBy('id', 'desc')
                                    ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

                if(empty($birthdays)) {
                    $return['result']=  "Empty birthday list ";
                    return $this->outputer->code(422)->error($return)->json();
                }

                $birthdays->getCollection()->transform(function ($item, $key) {

                    if ($item->image !== null) {
                         $item->image = asset('/') . $item->image;
                    }
                    return $item;
                });

                $birthdays_metadata = array(
                    "total" => $birthdays->total(),
                    "per_page" => $birthdays->perPage(),
                    "current_page" => $birthdays->currentPage(),
                    "last_page" => $birthdays->lastPage(),
                    "next_page_url" => $birthdays->nextPageUrl(),
                    "prev_page_url" => $birthdays->previousPageUrl(),
                    "from" => $birthdays->firstItem(),
                    "to" => $birthdays->lastItem()
                );

            /*---------Wedding Anniversary Details----------*/

                $weddings = FamilyMember::select('id','name as heading')
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_heading'))
                        ->addSelect('date_of_marriage as date','image as image','family_id')
                                ->whereRaw("DATE_FORMAT(date_of_marriage, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                                ->where('status', 1)
                                ->orderBy('name', 'asc');

                if($request['page_no']){
                    $pg_no=$page=$request['page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $weddings=$weddings->orderBy('id', 'desc')
                                    ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

                if(empty($weddings)) {
                    $return['result']=  "Empty birthday list ";
                    return $this->outputer->code(422)->error($return)->json();
                }

                $weddings->getCollection()->transform(function ($item, $key) {

                    if ($item->image !== null) {
                         $item->image = asset('/') . $item->image;
                    }
                    return $item;
                });

                $weddings_metadata = array(
                    "total" => $weddings->total(),
                    "per_page" => $weddings->perPage(),
                    "current_page" => $weddings->currentPage(),
                    "last_page" => $weddings->lastPage(),
                    "next_page_url" => $weddings->nextPageUrl(),
                    "prev_page_url" => $weddings->previousPageUrl(),
                    "from" => $weddings->firstItem(),
                    "to" => $weddings->lastItem()
                );


            

                /*---------Memories Details----------*/

                // $anniversary = MemoryDay::select('id','title as heading','note1 as sub_heading','date',
                //     DB::raw('"null" as image'))
                //                 ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                //                 ->where('status', 1)
                //                 ->orderBy('title', 'asc');

                // if($request['page_no']){
                //     $pg_no=$page=$request['page_no'];
                // }
                // if($request['per_page']){
                //    $per_pg=$page=$request['per_page'];
                // }
                // $anniversary=$anniversary->orderBy('id', 'desc')
                //                     ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

                // if(empty($anniversary)) {
                //     $return['result']=  "Empty anniversary list ";
                //     return $this->outputer->code(422)->error($return)->json();
                // }

                // $anniversary_metadata = array(
                //     "total" => $anniversary->total(),
                //     "per_page" => $anniversary->perPage(),
                //     "current_page" => $anniversary->currentPage(),
                //     "last_page" => $anniversary->lastPage(),
                //     "next_page_url" => $anniversary->nextPageUrl(),
                //     "prev_page_url" => $anniversary->previousPageUrl(),
                //     "from" => $anniversary->firstItem(),
                //     "to" => $anniversary->lastItem()
                // );



            /*---------Death Anniversary Details----------*/

                $obituary = Obituary::select('id','name_of_member as heading')
                   ->selectSub(function ($query) {
                        $query->select('families.family_name')
                            ->from('family_members')
                            ->join('families', 'family_members.family_id', '=', 'families.id')
                            ->whereColumn('family_members.id', 'obituaries.member_id')
                            ->limit(1);
                    }, 'sub_heading')
                    ->addSelect('date_of_death as date','photo as image')

                    ->whereRaw("DATE_FORMAT(date_of_death, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                    ->where('status',1)
                    ->orderByRaw("DAY(date_of_death) ASC")
                    ->orderBy('date_of_death', 'asc');


                if($request['page_no']){
                    $pg_no=$page=$request['page_no'];
                }
                if($request['per_page']){
                   $per_pg=$page=$request['per_page'];
                }
                $obituary=$obituary->orderBy('id', 'desc')
                                    ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

                if(empty($obituary)) {
                    $return['result']=  "Empty Death anniversary list ";
                    return $this->outputer->code(422)->error($return)->json();
                }

                $obituary->getCollection()->transform(function ($item, $key) {

                    if ($item->image !== null) {
                         $item->image = asset('/') . $item->image;
                    }
                    return $item;
                });

                $obituary_metadata = array(
                    "total" => $obituary->total(),
                    "per_page" => $obituary->perPage(),
                    "current_page" => $obituary->currentPage(),
                    "last_page" => $obituary->lastPage(),
                    "next_page_url" => $obituary->nextPageUrl(),
                    "prev_page_url" => $obituary->previousPageUrl(),
                    "from" => $obituary->firstItem(),
                    "to" => $obituary->lastItem()
                );

            $total = $birthdays->total() + $weddings->total() + $daily_readings->total() + $obituary->total();

            $mergedData = [
                'number_of_events' => $total,
                'events' => [
                    [
                        'type' => 'Daily Readings',
                        'list' => $daily_readings->items()
                    ],
                    [
                        'type' => 'Birthdays',
                        'list' => $birthdays->items()
                    ],
                    [
                        'type' => 'Wedding Anniversary',
                        'list' => $weddings->items()
                    ],
                    [
                        'type' => 'Death Anniversary',
                        'list' => $obituary->items()
                    ],
                ]
            ];

            $metadata = [
                'daily_readings_metadata' => $daily_readings_metadata,
                'birthdays_metadata' => $birthdays_metadata,
                'wedding_anniversary_metadata' => $weddings_metadata,
                'obituary_metadata' => $obituary_metadata,
            ];

            return $this->outputer->code(200) ->metadata($metadata)->success($mergedData)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

}
