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
            $date_value = PaymentDetail::first();


            $payments = PaymentDetail::select('payment_details.id',
                    'payment_details.amount','payment_details.category_id')
                    ->join('family_members', 'payment_details.family_head_id', '=', 'family_members.id')
                    ->where('family_members.family_id', $family_id)
                    ->where('payment_details.status', 1);
            $payments_sum = $payments->sum('payment_details.amount');

            $family = Family::select('id','family_code','family_name')->find($family_id);

            $payments=$payments->orderBy('payment_details.id')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($payments)) {
                $return['result']=  "Empty payments list ";
                return $this->outputer->code(422)->error($return)->json();
            }
            
            $result['date'] = $date_value['date'];
            $result['total'] = $payments_sum;
            $result['payments'] = $payments->getCollection();
            $result['family'] = $family;

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

    public function DailyDigest1(Request $request){
        try {

            $per_pg=100;
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

            $login_user = FamilyMember::select('id','name','image','family_id')
                            ->where('id',Auth::user()->id)->first();
            if ($login_user) {
                if ($login_user->image !== null) {
                    $login_user->image = asset('/') . $login_user->image;
                }
            }

            $bible_verse = BibleVerse::select('id','verse as heading','ref as sub_heading',DB::raw('"Bible Verse" as hash_value'))
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1)->first();
            if (!$bible_verse) {
                $random_verse = BibleVerse::select('id', 'verse as heading', 'ref as sub_heading',DB::raw('"Bible Verse" as hash_value'))
                        ->where('status', 1)
                        ->inRandomOrder()
                        ->first();
    
                $bible_verse = $random_verse ?? ['id' => null, 'heading' => 'Default Heading', 'sub_heading' => 'Default Subheading','hash_value'=>'Bible Verse'];
            }

            /*---------Daily Schedules Details----------*/

            $memoryData = MemoryDay::select('id',DB::raw('"ഓർമ" as heading'), 'title as sub_heading', 
                DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'), 
                DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'),DB::raw('"ഓർമ" as hash_value'),DB::raw('"null" as time'),)
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1); 

            $bibleCitationData = BiblicalCitation::select('id',DB::raw('"വേദഭാഗങ്ങൾ" as heading'), 'reference as sub_heading',
              DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),
               DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'),DB::raw('"വേദഭാഗങ്ങൾ" as hash_value'),DB::raw('"null" as time'),)
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1); 

            $church_activities = DailySchedules::select('id',DB::raw('"തിരുകർമ്മങ്ങൾ" as heading'),'Title as sub_heading', 
                DB::raw('IFNULL(DATE_FORMAT(date, "%d/%m/%Y"), "' . $todayFormatted . '") as date'), 
                DB::raw('"null" as image'),'venue as type',DB::raw('"True" as color'), 
                DB::raw('"null" as link'),DB::raw('"തിരുകർമ്മങ്ങൾ" as hash_value'), DB::raw('DATE_FORMAT(time, "%h:%i %p") as time'))
                ->whereDate('date',$today_string)
                ->where('status', 1); 

            $churchActivitiesData = $church_activities;

            // $daily_schedules = $memoryData->union($bibleCitationData)
            //                     ->union($churchActivitiesData)
            //                     ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            $daily_schedules = $bibleCitationData->union($churchActivitiesData)
                                ->union($memoryData)
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
                        ->addSelect('dob as date','image',DB::raw('"Birthdays" as type'),DB::raw('"False" as color'),'family_id', DB::raw('"null" as link'),DB::raw('"Birthdays" as hash_value'))
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
                         DB::raw('"null" as link'),DB::raw('"Vicar messages" as hash_value'))
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
                        ->addSelect('date_of_death as date','photo as image',DB::raw('"Obituaries" as type'),DB::raw('"False" as color'),'member_id', DB::raw('"null" as link'),'display_till_date',DB::raw('"Obituaries" as hash_value'))
                         ->whereDate('date_of_death', '<=', now())
                        ->whereDate('display_till_date', '>=', now())
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
            $obituary=$obituary->orderBy('date_of_death','desc')->orderBy('display_till_date','desc')
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
                        ->LoginUser($login_user)
                        ->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Directory(Request $request){

        try {

            /*---------Family Details----------*/

                $families = Family::select('id as id')
                        ->addSelect('family_name as sub_item',DB::raw('(SELECT name FROM family_members WHERE families.id = family_members.family_id AND head_of_family = 1 LIMIT 1) AS item')
                            ,DB::raw('"null" as image'),DB::raw('"Families" as type'))
                        ->where('status',1)
                        ->where('family_code','!=','CP001');
                if($request['search_word']){

                    $families->where(function ($query) use ($request) {
                        $query->where('family_name', 'like', $request['search_word'].'%')
                            ->orWhere('family_code', 'like', $request['search_word'].'%');
                    });
                }

                $families=$families->orderByRaw('item IS NULL, item ASC')
                    ->orderBy('item','asc')->get();

                $families->each(function ($family) {
                    $family->image = $family->family_head_image;
                });
                if(empty($families)) {
                    $return['result']=  "Empty family list ";
                    return $this->outputer->code(422)->error($return)->json();
                }

            /*---------Members Details----------*/

                $members = FamilyMember::select('id as id','name as item','image','mobile','family_id',DB::raw('"Members" as type'))
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_item'))
                        ->whereNull('date_of_death')
                        ->where('user_type',1)
                        ->where('status',1);
                if($request['search_word']){

                    $members->where(function ($query) use ($request) {
                        $query->where('name', 'like', $request['search_word'].'%')
                            ->orWhere('mobile', 'like', $request['search_word'].'%');
                    })
                    ->orwhereHas('BloodGroup', function ($query) use ($request) {
                        $query->where('blood_group_name', 'like', $request['search_word'].'%');
                    });
                }
               
                $members=$members->orderBy('name', 'asc')->get();
                $members->makeHidden(['family_name', 'family_head_name','prayer_group_name','marital_status_name',
                            'relationship_name','obituary_id']);

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

            /*---------Prayer Group Details----------*/

                $prayer_group = PrayerGroup::select('id as id','group_name as item','leader as sub_item',
                    DB::raw('"null" as image'),DB::raw('"Prayer Groups" as type'))
                                ->where('status',1);
                if($request['search_word']){
                    $prayer_group->where('group_name','like',$request['search_word'].'%');
                }
               
                $prayer_group=$prayer_group ->get();

                if(empty($prayer_group)) {
                    $return['result']=  "Empty prayer group list ";
                    return $this->outputer->code(422)->error($return)->json();
                }

            /*---------Organizations Details----------*/

                $organizations=FamilyMember::select(DB::raw('"1" as id'),'company_name as item',
                    DB::raw('CONCAT("No. of employees: ", COUNT(*)) as sub_item'),
                    DB::raw('"null" as image'),
                    DB::raw('"Organizations" as type'))
                    ->groupBy('company_name')
                    ->whereNotNull('company_name') 
                    ->where('status',1);

                if($request['search_word']){
                    $organizations->where('company_name','like',$request['search_word'].'%');
                }

                $organizations=$organizations->orderBy('company_name', 'asc')->get();

                if(empty($organizations)) {
                    $return['result']=  "Empty prayer group list ";
                    return $this->outputer->code(422)->error($return)->json();
                }

                $organizations->transform(function ($item) {
                    $item->setAppends([]);
                    $item->setRelations([]);
                    return $item;
                });
           

            if ($request['search_word']) {
                
                $search_results = $families
                    ->merge($members)
                    ->merge($prayer_group)
                    ->merge($organizations);

                $search_results_metadata = [
                    "total" => $search_results->count(),
                ];
            }

        $mergedData = [];
        $metadata = [];

        if ($request['search_word']) {
             $mergedData[] = ['category' => 'Search Results', 'list' => $search_results];
        }

        $mergedData[] = ['category' => 'Families', 'list' => $families];

        $mergedData[] = ['category' => 'Members', 'list' => $members];

        $mergedData[] = ['category' => 'Prayer Groups', 'list' => $prayer_group];

        $mergedData[] = ['category' => 'Organizations', 'list' => $organizations];

        return $this->outputer->code(200)->success($mergedData)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function OrganizationMembers(Request $request){

        try {
            $org_members= FamilyMember::select('id', 'name as item')
                    ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_item'), 'image', DB::raw('"OrganizationMembers" as type'), 'mobile','company_name')
                ->addSelect('family_id')
                ->where(function ($query) use ($request) {
                    $query->where('company_name', $request['organization'])
                          ->orWhere('company_name', 'like', $request['organization'] . '%');
                })
                ->whereNull('date_of_death')
                ->whereNotNull('company_name')
                ->where('user_type', 1)
                ->where('status', 1)
                ->orderBy('name', 'asc')
                ->get();

            $org_members->transform(function ($item, $key) {
                if ($item->image !== null) {
                    $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            if(empty($org_members)) {

                $return['result']=  "Empty members in this organization ";
                return $this->outputer->code(422)->error($return)->json();
            }
            return $this->outputer->code(200)
                        ->success($org_members)->json();
        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function YearlyCalenderEvents(Request $request){

        try {

            $year=date("Y");

            if($request['year']){
                $year = $request['year'];
            }

            $data = [];

            for ($month = 1; $month <= 12; $month++) {
                for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++) {
                    
                    $birthdays = FamilyMember::whereMonth('dob', $month)
                        ->whereDay('dob', $day)
                        ->whereNull('date_of_death')
                        ->where('status',1)
                        ->count();

                    $wedding_anniversaries = FamilyMember::whereMonth('date_of_marriage', $month)
                        ->whereDay('date_of_marriage', $day)
                        ->whereNull('date_of_death')
                        ->where('status',1)
                        ->count();

                    $obituaries = Obituary::whereMonth('date_of_death', $month)
                        ->whereDay('date_of_death', $day)
                        ->where('status',1)
                        ->count();

                    $total_events = $birthdays+$wedding_anniversaries+$obituaries;

                    $data[] = [
                        'date' => sprintf('%02d-%02d-%02d', $day, $month, $year),
                        'total_events' => $total_events
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
                    //DB::raw('"null" as image'),
                    DB::raw('JSON_ARRAY("null") as image'),
                    DB::raw('"Daily Readings" as hash_value'))
                                ->whereRaw("DATE_FORMAT(date, '%Y-%m-%d') = DATE_FORMAT('$date', '%Y-%m-%d')")
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

                $birthdays = FamilyMember::select('id',DB::raw('CONCAT("Happy birthday dear ", name) as heading'),)
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_heading'))
                        ->addSelect('dob as date','image as image','family_id',DB::raw('"Birthdays" as hash_value'))
                                ->whereRaw("DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                                ->whereRaw("DATE_FORMAT(dob, '%Y') != DATE_FORMAT('$date', '%Y')")
                                ->where('status', 1)
                                ->whereNull('date_of_death')
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
                        $item->image = [asset('/') . $item->image];
                    } else {
                        $item->image = [];
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

                // $weddings = FamilyMember::select('id',DB::raw('CONCAT("Happy wedding anniversary ", name) as heading'),)
                //         ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_heading'))
                //         ->addSelect('date_of_marriage as date','image as image','family_id',DB::raw('"Wedding Anniversary" as hash_value'))
                //                 ->whereRaw("DATE_FORMAT(date_of_marriage, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                //                 ->whereRaw("DATE_FORMAT(date_of_marriage, '%Y') != DATE_FORMAT('$date', '%Y')")
                //                 ->where('status', 1)
                //                 ->whereNull('date_of_death')
                //                 ->orderBy('name', 'asc');

                // if($request['page_no']){
                //     $pg_no=$page=$request['page_no'];
                // }
                // if($request['per_page']){
                //    $per_pg=$page=$request['per_page'];
                // }
                // $weddings=$weddings->orderBy('id', 'desc')
                //                     ->paginate($perPage=$per_pg,[],'',$page = $pg_no);

                // if(empty($weddings)) {
                //     $return['result']=  "Empty birthday list ";
                //     return $this->outputer->code(422)->error($return)->json();
                // }

                // $weddings->getCollection()->transform(function ($item, $key) {

                //     if ($item->image !== null) {
                //          $item->image = asset('/') . $item->image;
                //     }
                //     return $item;
                // });

                // $weddings_metadata = array(
                //     "total" => $weddings->total(),
                //     "per_page" => $weddings->perPage(),
                //     "current_page" => $weddings->currentPage(),
                //     "last_page" => $weddings->lastPage(),
                //     "next_page_url" => $weddings->nextPageUrl(),
                //     "prev_page_url" => $weddings->previousPageUrl(),
                //     "from" => $weddings->firstItem(),
                //     "to" => $weddings->lastItem()
                // );




                $weddings = FamilyMember::select('id', 'name', 'image', 'date_of_marriage', 'family_id')
                    ->whereRaw("DATE_FORMAT(date_of_marriage, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                    ->whereRaw("DATE_FORMAT(date_of_marriage, '%Y') != DATE_FORMAT('$date', '%Y')")
                    ->where('status', 1)
                    ->whereNull('date_of_death')
                    //->orderBy('name', 'asc')
                    ->orderByRaw("CASE WHEN gender = 'Male' THEN 0 ELSE 1 END")
                    ->get();

                $groupedWeddings = $weddings->groupBy(function ($item) {
                    return $item->family_id . '-' . $item->date_of_marriage;
                });

                $finalWeddings = collect();
                foreach ($groupedWeddings as $key => $members) {
                    $family_id = $members->first()->family_id;
                    $family_name = DB::table('families')->where('id', $family_id)->value('family_name');

                    if ($members->count() > 1) {
                        $type = 'couples';
                        $names = $members->pluck('name')->toArray();
                        $images = $members->pluck('image')->toArray();
                        $item = [
                            'id' => $members->first()->id,
                            'heading' => "Wedding anniversary of \n" . implode(' and ', $names),
                            'sub_heading' => $family_name,
                            'date' => $members->first()->date_of_marriage,
                            'image' => $images,
                            'family_id' => $family_id,
                            'hash_value' => 'Wedding Anniversary',
                            'type' => $type
                        ];
                    } else {
                        $type = 'singles';
                        $member = $members->first();
                        $item = [
                            'id' => $member->id,
                            'heading' => "Wedding anniversary of \n" . $member->name,
                            'sub_heading' => $family_name,
                            'date' => $member->date_of_marriage,
                            'image' => [$member->image],
                            'family_id' => $family_id,
                            'hash_value' => 'Wedding Anniversary',
                            'type' => $type
                        ];
                    }

                    $finalWeddings->push($item);
                }

                $page = $request['page_no'] ?? 1;
                $per_pg = $request['per_page'] ?? 15;

                $paginatedWeddings = new \Illuminate\Pagination\LengthAwarePaginator(
                    $finalWeddings->forPage($page, $per_pg),
                    $finalWeddings->count(),
                    $per_pg,
                    $page,
                    ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
                );

                if ($paginatedWeddings->isEmpty()) {
                    $return['result'] = "Empty birthday list";
                    return $this->outputer->code(422)->error($return)->json();
                }

                $paginatedWeddings->getCollection()->transform(function ($item, $key) {
                    if (isset($item['image']) && $item['image'] !== null) {
                        //$item['image'] = asset('/') . $item['image'];

                        $item['image'] = array_map(function ($image) {
                            return $image !== null ? asset('/') . $image : $image;
                        }, $item['image']);
                    }
                    if (isset($item['images'])) {
                        $item['images'] = array_map(function ($image) {
                            return $image !== null ? asset('/') . $image : $image;
                        }, $item['images']);
                    }
                    return $item;
                });

                $weddings_metadata = array(
                    "total" => $paginatedWeddings->total(),
                    "per_page" => $paginatedWeddings->perPage(),
                    "current_page" => $paginatedWeddings->currentPage(),
                    "last_page" => $paginatedWeddings->lastPage(),
                    "next_page_url" => $paginatedWeddings->nextPageUrl(),
                    "prev_page_url" => $paginatedWeddings->previousPageUrl(),
                    "from" => $paginatedWeddings->firstItem(),
                    "to" => $paginatedWeddings->lastItem()
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

                $obituary = Obituary::select('id',DB::raw('CONCAT("Death anniversary of ", name_of_member) as heading'))
                   ->selectSub(function ($query) {
                        $query->select('families.family_name')
                            ->from('family_members')
                            ->join('families', 'family_members.family_id', '=', 'families.id')
                            ->whereColumn('family_members.id', 'obituaries.member_id')
                            ->limit(1);
                    }, 'sub_heading')
                    ->addSelect('date_of_death as date','photo as image',
                        DB::raw('"Death Anniversary" as hash_value'))

                    ->whereRaw("DATE_FORMAT(date_of_death, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                    ->whereRaw("DATE_FORMAT(date_of_death, '%Y') != DATE_FORMAT('$date', '%Y')")
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
                        $item->image = [asset('/') . $item->image];
                    } else {
                        $item->image = [];
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

            $total = $birthdays->total() + $paginatedWeddings->total() + $daily_readings->total() + $obituary->total();

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
                        'list' => $paginatedWeddings->items()
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


    // public function Directory1(Request $request){
    
    //     try {
    //         $per_pg = 10;
    //         $tab_no = $request->input('tab_no');

    //         /*---------Family Details----------*/
    //         $familiesQuery = Family::select('id as id')
    //             ->addSelect('family_name as item', DB::raw('(SELECT name FROM family_members WHERE families.id = family_members.family_id AND head_of_family = 1 LIMIT 1) AS sub_item'), DB::raw('"null" as image'), DB::raw('"Families" as type'))
    //             ->where('status', 1)
    //             ->where('family_code', '!=', 'CP001');
    //         if ($request['search_word']) {
    //             $familiesQuery->where(function ($query) use ($request) {
    //                 $query->where('family_name', 'like', $request['search_word'] . '%')
    //                     ->orWhere('family_code', 'like', $request['search_word'] . '%');
    //             });
    //         }
    //         $families = $familiesQuery->orderByRaw('sub_item IS NULL, sub_item ASC')
    //             ->orderBy('sub_item', 'asc')
    //             ->paginate($per_pg, ['*'], 'families_page', $request->input('families_page', 1));

    //         $families->each(function ($family) {
    //             $family->image = $family->family_head_image;
    //         });

    //         $family_metadata = array(
    //                     "total" => $families->total(),
    //                     "per_page" => $families->perPage(),
    //                     "current_page" => $families->currentPage(),
    //                     "last_page" => $families->lastPage(),
    //                     "next_page_url" => $families->nextPageUrl(),
    //                     "prev_page_url" => $families->previousPageUrl(),
    //                     "from" => $families->firstItem(),
    //                     "to" => $families->lastItem()
    //                 );

    //         /*---------Members Details----------*/
    //         $membersQuery = FamilyMember::select('id as id', 'name as item')
    //             ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_item'), 'image', DB::raw('"Members" as type'), 'mobile')
    //             ->addSelect('family_id')
    //             ->whereNull('date_of_death')
    //             ->where('user_type', 1)
    //             ->where('status', 1);
    //         if ($request['search_word']) {
    //             $membersQuery->where(function ($query) use ($request) {
    //                 $query->where('name', 'like', $request['search_word'] . '%')
    //                     ->orWhere('mobile', 'like', $request['search_word'] . '%')
    //                     ->orWhere('nickname', 'like', $request['search_word'] . '%');
    //             })
    //                 ->orwhereHas('BloodGroup', function ($query) use ($request) {
    //                     $query->where('blood_group_name', 'like', $request['search_word'] . '%');
    //                 });
    //         }
    //         $members = $membersQuery->orderBy('name', 'asc')
    //             ->paginate($per_pg, ['*'], 'members_page', $request->input('members_page', 1));

    //         $members->transform(function ($item, $key) {
    //             if ($item->image !== null) {
    //                 $item->image = asset('/') . $item->image;
    //             }
    //             return $item;
    //         });

    //         $members_metadata = array(
    //                     "total" => $members->total(),
    //                     "per_page" => $members->perPage(),
    //                     "current_page" => $members->currentPage(),
    //                     "last_page" => $members->lastPage(),
    //                     "next_page_url" => $members->nextPageUrl(),
    //                     "prev_page_url" => $members->previousPageUrl(),
    //                     "from" => $members->firstItem(),
    //                     "to" => $members->lastItem()
    //                 );

    //         /*---------Prayer Group Details----------*/
    //         $prayer_groupQuery = PrayerGroup::select('id as id', 'group_name as item', 'leader as sub_item', DB::raw('"null" as image'), DB::raw('"Prayer Groups" as type'))
    //             ->where('status', 1);
    //         if ($request['search_word']) {
    //             $prayer_groupQuery->where('group_name', 'like', $request['search_word'] . '%');
    //         }
    //         $prayer_group = $prayer_groupQuery->paginate($per_pg, ['*'], 'prayer_group_page', $request->input('prayer_group_page', 1));

    //          $prayer_group_metadata = array(
    //                     "total" => $prayer_group->total(),
    //                     "per_page" => $prayer_group->perPage(),
    //                     "current_page" => $prayer_group->currentPage(),
    //                     "last_page" => $prayer_group->lastPage(),
    //                     "next_page_url" => $prayer_group->nextPageUrl(),
    //                     "prev_page_url" => $prayer_group->previousPageUrl(),
    //                     "from" => $prayer_group->firstItem(),
    //                     "to" => $prayer_group->lastItem()
    //                 );

    //         /*---------Organizations Details----------*/
    //         $organizationsQuery = FamilyMember::select(DB::raw('"1" as id'), 'company_name as item', DB::raw('CONCAT("No. of employees: ", COUNT(*)) as sub_item'), DB::raw('"null" as image'), DB::raw('"Organizations" as type'))
    //             ->groupBy('company_name')
    //             ->whereNotNull('company_name')
    //             ->where('status', 1);
    //         if ($request['search_word']) {
    //             $organizationsQuery->where('company_name', 'like', $request['search_word'] . '%');
    //         }
    //         $organizations = $organizationsQuery->orderBy('id', 'desc')
    //             ->paginate($per_pg, ['*'], 'organizations_page', $request->input('organizations_page', 1));

    //         $organizations->transform(function ($item) {
    //             $item->setAppends([]);
    //             $item->setRelations([]);
    //             return $item;
    //         });

    //         $organization_metadata = array(
    //                     "total" => $organizations->total(),
    //                     "per_page" => $organizations->perPage(),
    //                     "current_page" => $organizations->currentPage(),
    //                     "last_page" => $organizations->lastPage(),
    //                     "next_page_url" => $organizations->nextPageUrl(),
    //                     "prev_page_url" => $organizations->previousPageUrl(),
    //                     "from" => $organizations->firstItem(),
    //                     "to" => $organizations->lastItem()
    //                 );

    //         /*---------Result Formatting----------*/
    //         $mergedData = [];
    //         $metadata = [];

    //         if ($tab_no == 1) {
    //             $mergedData[] = ['category' => 'Families', 'list' => $families->getCollection()];
    //             $metadata = [$family_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Families', 'list' => []];
    //         }

    //         if ($tab_no == 2) {
    //             $mergedData[] = ['category' => 'Members', 'list' => $members->getCollection()];
    //             $metadata = [$members_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Members', 'list' => []];
    //         }

    //         if ($tab_no == 3) {
    //             $mergedData[] = ['category' => 'Prayer Groups', 'list' => $prayer_group->getCollection()];
    //             $metadata = [$prayer_group_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Prayer Groups', 'list' => []];
    //         }

    //         if ($tab_no == 4) {
    //             $mergedData[] = ['category' => 'Organizations', 'list' => $organizations->getCollection()];
    //             $metadata = [$organization_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Organizations', 'list' => []];
    //         }

    //         return $this->outputer->code(200)
    //             ->success($mergedData)
    //             ->metadata($metadata)
    //             ->json();

    //     } catch (\Exception $e) {
    //         $return['result'] = $e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    // public function Directory2(Request $request)
    // {
    //     try {
    //         $per_pg = 10;
    //         $tab_no = $request->input('tab_no');
    //         $search_word = $request->input('search_word');

    //         /*---------Family Details----------*/
    //         $familiesQuery = Family::select('id as id')
    //             ->addSelect('family_name as item', DB::raw('(SELECT name FROM family_members WHERE families.id = family_members.family_id AND head_of_family = 1 LIMIT 1) AS sub_item'), DB::raw('"null" as image'), DB::raw('"Families" as type'))
    //             ->where('status', 1)
    //             ->where('family_code', '!=', 'CP001');
    //         if ($search_word) {
    //             $familiesQuery->where(function ($query) use ($search_word) {
    //                 $query->where('family_name', 'like', $search_word . '%')
    //                     ->orWhere('family_code', 'like', $search_word . '%');
    //             });
    //         }
    //         $families = $familiesQuery->orderByRaw('sub_item IS NULL, sub_item ASC')
    //             ->orderBy('sub_item', 'asc')
    //             ->paginate($per_pg, ['*'], 'families_page', $request->input('families_page', 1));

    //         $families->each(function ($family) {
    //             $family->image = $family->family_head_image;
    //         });

    //         $family_metadata = [
    //             "total" => $families->total(),
    //             "per_page" => $families->perPage(),
    //             "current_page" => $families->currentPage(),
    //             "last_page" => $families->lastPage(),
    //             "next_page_url" => $families->nextPageUrl(),
    //             "prev_page_url" => $families->previousPageUrl(),
    //             "from" => $families->firstItem(),
    //             "to" => $families->lastItem()
    //         ];

    //         /*---------Members Details----------*/
    //         $membersQuery = FamilyMember::select('id as id', 'name as item')
    //             ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_item'), 'image', DB::raw('"Members" as type'), 'mobile')
    //             ->addSelect('family_id')
    //             ->whereNull('date_of_death')
    //             ->where('user_type', 1)
    //             ->where('status', 1);
    //         if ($search_word) {
    //             $membersQuery->where(function ($query) use ($search_word) {
    //                 $query->where('name', 'like', $search_word . '%')
    //                     ->orWhere('mobile', 'like', $search_word . '%')
    //                     ->orWhere('nickname', 'like', $search_word . '%');
    //             })
    //                 ->orwhereHas('BloodGroup', function ($query) use ($search_word) {
    //                     $query->where('blood_group_name', 'like', $search_word . '%');
    //                 });
    //         }
    //         $members = $membersQuery->orderBy('name', 'asc')
    //             ->paginate($per_pg, ['*'], 'members_page', $request->input('members_page', 1));

    //         $members->transform(function ($item, $key) {
    //             if ($item->image !== null) {
    //                 $item->image = asset('/') . $item->image;
    //             }
    //             return $item;
    //         });

    //         $members_metadata = [
    //             "total" => $members->total(),
    //             "per_page" => $members->perPage(),
    //             "current_page" => $members->currentPage(),
    //             "last_page" => $members->lastPage(),
    //             "next_page_url" => $members->nextPageUrl(),
    //             "prev_page_url" => $members->previousPageUrl(),
    //             "from" => $members->firstItem(),
    //             "to" => $members->lastItem()
    //         ];

    //         /*---------Prayer Group Details----------*/
    //         $prayer_groupQuery = PrayerGroup::select('id as id', 'group_name as item', 'leader as sub_item', DB::raw('"null" as image'), DB::raw('"Prayer Groups" as type'))
    //             ->where('status', 1);
    //         if ($search_word) {
    //             $prayer_groupQuery->where('group_name', 'like', $search_word . '%');
    //         }
    //         $prayer_group = $prayer_groupQuery->paginate($per_pg, ['*'], 'prayer_group_page', $request->input('prayer_group_page', 1));

    //         $prayer_group_metadata = [
    //             "total" => $prayer_group->total(),
    //             "per_page" => $prayer_group->perPage(),
    //             "current_page" => $prayer_group->currentPage(),
    //             "last_page" => $prayer_group->lastPage(),
    //             "next_page_url" => $prayer_group->nextPageUrl(),
    //             "prev_page_url" => $prayer_group->previousPageUrl(),
    //             "from" => $prayer_group->firstItem(),
    //             "to" => $prayer_group->lastItem()
    //         ];

    //         /*---------Organizations Details----------*/
    //         $organizationsQuery = FamilyMember::select(DB::raw('"1" as id'), 'company_name as item', DB::raw('CONCAT("No. of employees: ", COUNT(*)) as sub_item'), DB::raw('"null" as image'), DB::raw('"Organizations" as type'))
    //             ->groupBy('company_name')
    //             ->whereNotNull('company_name')
    //             ->where('status', 1);
    //         if ($search_word) {
    //             $organizationsQuery->where('company_name', 'like', $search_word . '%');
    //         }
    //         $organizations = $organizationsQuery->orderBy('id', 'desc')
    //             ->paginate($per_pg, ['*'], 'organizations_page', $request->input('organizations_page', 1));

    //         $organizations->transform(function ($item) {
    //             $item->setAppends([]);
    //             $item->setRelations([]);
    //             return $item;
    //         });

    //         $organization_metadata = [
    //             "total" => $organizations->total(),
    //             "per_page" => $organizations->perPage(),
    //             "current_page" => $organizations->currentPage(),
    //             "last_page" => $organizations->lastPage(),
    //             "next_page_url" => $organizations->nextPageUrl(),
    //             "prev_page_url" => $organizations->previousPageUrl(),
    //             "from" => $organizations->firstItem(),
    //             "to" => $organizations->lastItem()
    //         ];

    //         /*---------Search Result Formatting----------*/
    //         $searchResults = [];
    //         if ($search_word) {
    //             $searchResults = array_merge(
    //                 $familiesQuery->get()->toArray(),
    //                 $membersQuery->get()->toArray(),
    //                 $prayer_groupQuery->get()->toArray(),
    //                 $organizationsQuery->get()->toArray()
    //             );
    //         }

    //         /*---------Result Formatting----------*/
    //         $mergedData = [];
    //         $metadata = [];

    //         if ($search_word) {
    //             $mergedData[] = ['category' => 'Search Results', 'list' => $searchResults];
    //         }

    //         if ($tab_no == 1) {
    //             $mergedData[] = ['category' => 'Families', 'list' => $families->getCollection()];
    //             $metadata = [$family_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Families', 'list' => []];
    //         }

    //         if ($tab_no == 2) {
    //             $mergedData[] = ['category' => 'Members', 'list' => $members->getCollection()];
    //             $metadata = [$members_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Members', 'list' => []];
    //         }

    //         if ($tab_no == 3) {
    //             $mergedData[] = ['category' => 'Prayer Groups', 'list' => $prayer_group->getCollection()];
    //             $metadata = [$prayer_group_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Prayer Groups', 'list' => []];
    //         }

    //         if ($tab_no == 4) {
    //             $mergedData[] = ['category' => 'Organizations', 'list' => $organizations->getCollection()];
    //             $metadata = [$organization_metadata];
    //         } else {
    //             $mergedData[] = ['category' => 'Organizations', 'list' => []];
    //         }

    //         return $this->outputer->code(200)
    //             ->success($mergedData)
    //             ->metadata($metadata)
    //             ->json();

    //     } catch (\Exception $e) {
    //         $return['result'] = $e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    // public function DirectoryNew(Request $request)
    // {
    //     try {
    //         $tab_no = $request->input('tab_no');
    //         $search_word = $request->input('search_word');

    //         /*---------Family Details----------*/
    //         $familiesQuery = Family::select('id as id')
    //             ->addSelect('family_name as item', DB::raw('(SELECT name FROM family_members WHERE families.id = family_members.family_id AND head_of_family = 1 LIMIT 1) AS sub_item'), DB::raw('"null" as image'), DB::raw('"Families" as type'))
    //             ->where('status', 1)
    //             ->where('family_code', '!=', 'CP001');
    //         if ($search_word) {
    //             $familiesQuery->where(function ($query) use ($search_word) {
    //                 $query->where('family_name', 'like', $search_word . '%')
    //                     ->orWhere('family_code', 'like', $search_word . '%');
    //             });
    //         }
    //         $families = $familiesQuery->orderByRaw('sub_item IS NULL, sub_item ASC')
    //             ->orderBy('sub_item', 'asc')
    //             ->get();

    //         $families->each(function ($family) {
    //             $family->image = $family->family_head_image;
    //         });

    //         /*---------Members Details----------*/
    //         $membersQuery = FamilyMember::select('id as id', 'name as item')
    //             ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_item'), 'image', DB::raw('"Members" as type'), 'mobile')
    //             ->addSelect('family_id')
    //             ->whereNull('date_of_death')
    //             ->where('user_type', 1)
    //             ->where('status', 1);
    //         if ($search_word) {
    //             $membersQuery->where(function ($query) use ($search_word) {
    //                 $query->where('name', 'like', $search_word . '%')
    //                     ->orWhere('mobile', 'like', $search_word . '%')
    //                     ->orWhere('nickname', 'like', $search_word . '%');
    //             })
    //                 ->orWhereHas('BloodGroup', function ($query) use ($search_word) {
    //                     $query->where('blood_group_name', 'like', $search_word . '%');
    //                 });
    //         }
    //         $members = $membersQuery->orderBy('name', 'asc')
    //             ->get();

    //         $members->transform(function ($item, $key) {
    //             if ($item->image !== null) {
    //                 $item->image = asset('/') . $item->image;
    //             }
    //             return $item;
    //         });

    //         /*---------Prayer Group Details----------*/
    //         $prayer_groupQuery = PrayerGroup::select('id as id', 'group_name as item', 'leader as sub_item', DB::raw('"null" as image'), DB::raw('"Prayer Groups" as type'))
    //             ->where('status', 1);
    //         if ($search_word) {
    //             $prayer_groupQuery->where('group_name', 'like', $search_word . '%');
    //         }
    //         $prayer_group = $prayer_groupQuery->get();

    //         /*---------Organizations Details----------*/
    //         $organizationsQuery = FamilyMember::select(DB::raw('"1" as id'), 'company_name as item', DB::raw('CONCAT("No. of employees: ", COUNT(*)) as sub_item'), DB::raw('"null" as image'), DB::raw('"Organizations" as type'))
    //             ->groupBy('company_name')
    //             ->whereNotNull('company_name')
    //             ->whereNull('date_of_death')
    //             ->where('user_type', 1)
    //             ->where('status', 1);
    //         if ($search_word) {
    //             //$organizationsQuery->where('company_name', 'like', $search_word);
    //             $organizationsQuery->where(function ($query) use ($search_word) {
    //                 $query->where('company_name', $search_word)
    //                       ->orWhere('company_name', 'like', $search_word . '%');
    //             });
    //         }
    //         $organizations = $organizationsQuery->orderBy('company_name', 'asc')
    //             ->get();

    //         $organizations->transform(function ($item) {
    //             $item->setAppends([]);
    //             $item->setRelations([]);
    //             return $item;
    //         });

    //         /*---------Search Result Formatting----------*/
    //         $searchResults = [];
    //         if ($search_word) {
    //             $searchResults = array_merge(
    //                 $familiesQuery->get()->toArray(),
    //                 $membersQuery->get()->toArray(),
    //                 $prayer_groupQuery->get()->toArray(),
    //                 $organizationsQuery->get()->toArray()
    //             );
    //         }

    //         /*---------Result Formatting----------*/
    //         $mergedData = [];

    //         if ($search_word) {
    //             $mergedData[] = ['category' => 'Search Results', 'list' => $searchResults];
    //         }

    //         if ($tab_no == 1) {
    //             $mergedData[] = ['category' => 'Families', 'list' => $families];
    //         } else {
    //             $mergedData[] = ['category' => 'Families', 'list' => []];
    //         }

    //         if ($tab_no == 2) {
    //             $mergedData[] = ['category' => 'Members', 'list' => $members];
    //         } else {
    //             $mergedData[] = ['category' => 'Members', 'list' => []];
    //         }

    //         if ($tab_no == 3) {
    //             $mergedData[] = ['category' => 'Prayer Groups', 'list' => $prayer_group];
    //         } else {
    //             $mergedData[] = ['category' => 'Prayer Groups', 'list' => []];
    //         }

    //         if ($tab_no == 4) {
    //             $mergedData[] = ['category' => 'Organizations', 'list' => $organizations];
    //         } else {
    //             $mergedData[] = ['category' => 'Organizations', 'list' => []];
    //         }

    //         return $this->outputer->code(200)
    //             ->success($mergedData)
    //             ->json();

    //     } catch (\Exception $e) {
    //         $return['result'] = $e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    // public function Families(Request $request){

    //     try {

    //         $pg_no='';
    //         $per_pg='';

    //         $families = Family::select('*')->where('status',1);

    //         if($request['search_word']){
    //             $families->where('family_name','like',$request['search_word'].'%')
    //                         ->orwhere('family_code','like',$request['search_word'].'%');
    //         }
    //         if($request['page_no']){
    //             $pg_no=$page=$request['page_no'];
    //         }
    //         if($request['per_page']){
    //            $per_pg=$page=$request['per_page'];
    //         }
    //         $families=$families->orderBy('family_name','asc')
    //                             ->paginate($perPage=$per_pg,[],'',$page =$pg_no);

    //         if(empty($families)) {
    //             $return['result']=  "Empty family list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $metadata = array(
    //             "total" => $families->total(),
    //             "per_page" => $families->perPage(),
    //             "current_page" => $families->currentPage(),
    //             "last_page" => $families->lastPage(),
    //             "next_page_url" => $families->nextPageUrl(),
    //             "prev_page_url" => $families->previousPageUrl(),
    //             "from" => $families->firstItem(),
    //             "to" => $families->lastItem()
    //         );

    //         return $this->outputer->code(200)->metadata($metadata)
    //                     ->success($families->getCollection())->json();

    //     }catch (\Exception $e) {

    //         $return['result']=$e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

    // public function Members(Request $request){

    //     try {

    //         $pg_no='';
    //         $per_pg='';

    //         $members = FamilyMember::select('*')->where('status',1);

    //         if($request['search_word']){
    //             $members->where('name','like',$request['search_word'].'%')
    //                         ->orwhere('nickname','like',$request['search_word'].'%');
    //         }
    //         if($request['page_no']){
    //             $pg_no=$page=$request['page_no'];
    //         }
    //         if($request['per_page']){
    //            $per_pg=$page=$request['per_page'];
    //         }
    //         $members=$members->orderBy('name', 'asc')->paginate($perPage=$per_pg,[],'',$page =$pg_no);

    //         if(empty($members)) {
    //             $return['result']=  "Empty bible verse list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $metadata = array(
    //             "total" => $members->total(),
    //             "per_page" => $members->perPage(),
    //             "current_page" => $members->currentPage(),
    //             "last_page" => $members->lastPage(),
    //             "next_page_url" => $members->nextPageUrl(),
    //             "prev_page_url" => $members->previousPageUrl(),
    //             "from" => $members->firstItem(),
    //             "to" => $members->lastItem()
    //         );

    //         return $this->outputer->code(200)->metadata($metadata)
    //                     ->success($members->getCollection())->json();

    //     }catch (\Exception $e) {

    //         $return['result']=$e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }

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

    //     public function Bulletin(Request $request){

    //     try {

    //         $per_pg='';
    //         $pg_no='';

    //         /*---------Events Details----------*/

    //         $events = Event::select('id','date','event_name as sub_item','venue as item','details','image',
    //             DB::raw('"Events" as type_value'),DB::raw('"False" as color'),DB::raw('"Events" as hash_value'),
    //             'link')
    //             ->where('status',1);
    //         if($request['search_word']){
    //             $events->where('event_name','like',$request['search_word'].'%')
    //                     ->orwhere('venue','like',$request['search_word'].'%')
    //                     ->orwhere('details','like',$request['search_word'].'%');
    //         }
    //         // if($request['page_no']){
    //         //     $pg_no=$request['page_no'];
    //         // }
    //         // if($request['per_page']){
    //         //    $per_pg=$request['per_page'];
    //         // }
    //         $events=$events->orderBy('id', 'desc')
    //             //->paginate($perPage=$per_pg,[],'',$page = $pg_no);
    //             ->get();

    //         if(empty($events)) {
    //             $return['result']=  "Empty events list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $events->transform(function ($item, $key) {

    //             if ($item->image !== null) {
    //                  $item->image = asset('/') . $item->image;
    //             }
    //             return $item;
    //         });

    //         // $events_metadata = array(
    //         //     "total" => $events->total(),
    //         //     "per_page" => $events->perPage(),
    //         //     "current_page" => $events->currentPage(),
    //         //     "last_page" => $events->lastPage(),
    //         //     "next_page_url" => $events->nextPageUrl(),
    //         //     "prev_page_url" => $events->previousPageUrl(),
    //         //     "from" => $events->firstItem(),
    //         //     "to" => $events->lastItem()
    //         // );

    //         /*---------News & Announcements Details----------*/

    //         $newsAnnouncements = NewsAnnouncement::select('id','updated_at as date','heading as sub_item','type_name as item')
    //         ->addSelect('body as details','image','type' ,'group_org_id',
    //             DB::raw('"News & Announcements" as type_value'),DB::raw('"False" as color'),'type_name as hash_value','link')
    //         ->where('status',1);
    //         if($request['search_word']){
    //             // $newsAnnouncements->where('heading','like',$request['search_word'].'%')
    //             //                 ->orwhere('body','like',$request['search_word'].'%');

    //             $searchTerm = strtolower($request['search_word']);
    //             $newsAnnouncements->where(function ($query) use ($searchTerm) {
    //                 $query->where('heading', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('type_name', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('body', 'like', '%' . $searchTerm . '%');
    //             });
    //         }
    //         // if($request['page_no']){
    //         //     $pg_no=$page=$request['page_no'];
    //         // }
    //         // if($request['per_page']){
    //         //    $per_pg=$page=$request['per_page'];
    //         // }
    //         $newsAnnouncements=$newsAnnouncements->orderBy('id', 'desc')
    //                                // ->paginate($perPage=$per_pg,[],'',$page = $pg_no);
    //                             ->get();

    //         if(empty($newsAnnouncements)) {
    //             $return['result']=  "Empty marital status list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $newsAnnouncements->transform(function ($item, $key) {

    //             if ($item->image !== null) {
    //                  $item->image = asset('/') . $item->image;
    //             }
    //             return $item;
    //         });

    //         // $newsAnnouncements_metadata = array(
    //         //     "total" => $newsAnnouncements->total(),
    //         //     "per_page" => $newsAnnouncements->perPage(),
    //         //     "current_page" => $newsAnnouncements->currentPage(),
    //         //     "last_page" => $newsAnnouncements->lastPage(),
    //         //     "next_page_url" => $newsAnnouncements->nextPageUrl(),
    //         //     "prev_page_url" => $newsAnnouncements->previousPageUrl(),
    //         //     "from" => $newsAnnouncements->firstItem(),
    //         //     "to" => $newsAnnouncements->lastItem()
    //         // );

    //         /*---------Notifications Details----------*/

    //         $notifications = Notification::select('id','updated_at as date','title as sub_item','type_name as item')
    //         // ->addSelect(DB::raw("
    //         //     CASE
    //         //         WHEN type = 1 THEN 'Trustee'
    //         //         WHEN type = 2 THEN 'Secretary'
    //         //         WHEN type = 3 THEN 'Prayer Group'
    //         //         ELSE 'Organization'
    //         //     END AS sub_item
    //         // "))
    //         ->addSelect('content as details','group_org_id','type',
    //             DB::raw('"Notifications" as type_value'),DB::raw('"False" as color'),'type_name as hash_value',
    //             DB::raw('"null" as link'))
    //         // ->addSelect(DB::raw("
    //         //     CASE
    //         //         WHEN type = 1 THEN 'Trustee'
    //         //         WHEN type = 2 THEN 'Secretary'
    //         //         WHEN type = 3 THEN 'Prayer Group'
    //         //         ELSE 'Organization'
    //         //     END AS hash_value
    //         // "),DB::raw('"null" as link'))
    //         ->where('status',1);

    //         if($request['search_word']){
    //             // $notifications->where('title','like',$request['search_word'].'%')
    //             //             ->orwhere('content','like',$request['search_word'].'%');

    //             $searchTerm = strtolower($request['search_word']);
    //             $notifications->where(function ($query) use ($searchTerm) {
    //                 $query->where('title', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('type_name', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('content', 'like', '%' . $searchTerm . '%');
    //             });
    //             switch ($searchTerm) {
    //                 case 'trustee':
    //                     $notifications->where('type', 1);
    //                     break;
    //                 case 'secretary':
    //                     $notifications->where('type', 2);
    //                     break;
    //                 case 'prayer group':
    //                     $notifications->where('type', 3);
    //                     break;
    //                 case 'organization':
    //                     $newsAnnouncements->where('type', 4);
    //                     break;
    //             }
    //         }
    //         // if($request['page_no']){
    //         //     $pg_no=$page=$request['page_no'];
    //         // }
    //         // if($request['per_page']){
    //         //    $per_pg=$page=$request['per_page'];
    //         // }
    //         $notifications=$notifications->orderBy('id', 'desc')
    //                             //->paginate($perPage=$per_pg,[],'',$page = $pg_no);
    //                         ->get();

    //         $notifications->transform(function ($notif) {
    //             $notif->image = null;
    //             return $notif;
    //         });
    //         if(empty($notifications)) {
    //             $return['result']=  "Empty prayer group list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         // $notifications_metadata = array(
    //         //     "total" => $notifications->total(),
    //         //     "per_page" => $notifications->perPage(),
    //         //     "current_page" => $notifications->currentPage(),
    //         //     "last_page" => $notifications->lastPage(),
    //         //     "next_page_url" => $notifications->nextPageUrl(),
    //         //     "prev_page_url" => $notifications->previousPageUrl(),
    //         //     "from" => $notifications->firstItem(),
    //         //     "to" => $notifications->lastItem()
    //         // );

    //         /*---------Obituaries Details----------*/

    //         $obituaries = Obituary::select('id','date_of_death as date','name_of_member as sub_item','notes as item')
    //             ->selectSub(function ($query) {
    //                 $query->select('families.family_name')
    //                     ->from('family_members')
    //                     ->join('families', 'family_members.family_id', '=', 'families.id')
    //                     ->whereColumn('family_members.id', 'obituaries.member_id')
    //                     ->limit(1);
    //             }, 'details')
    //         ->addSelect('photo as image',
    //             DB::raw('"Obituaries" as type_value'),DB::raw('"False" as color'), DB::raw('"Obituaries" as hash_value'),
    //             'funeral_date as link')
    //         ->where('date_of_death', \Carbon\Carbon::today())
    //         ->where('status',1);

    //         if($request['search_word']){
    //             $obituaries->where('name_of_member','like',$request['search_word'].'%');
    //         }
    //         // if($request['page_no']){
    //         //     $pg_no=$page=$request['page_no'];
    //         // }
    //         // if($request['per_page']){
    //         //    $per_pg=$page=$request['per_page'];
    //         // }
    //         $obituaries=$obituaries->orderBy('id', 'desc')
    //             //->paginate($perPage=$per_pg,[],'',$page = $pg_no);
    //             ->get();

    //         if(empty($obituaries)) {
    //             $return['result']=  "Empty prayer group list ";
    //             return $this->outputer->code(422)->error($return)->json();
    //         }

    //         $obituaries->transform(function ($item, $key) {

    //             if ($item->image !== null) {
    //                  $item->image = asset('/') . $item->image;
    //             }
    //             return $item;
    //         });

    //         // $obituaries_metadata = array(
    //         //     "total" => $obituaries->total(),
    //         //     "per_page" => $obituaries->perPage(),
    //         //     "current_page" => $obituaries->currentPage(),
    //         //     "last_page" => $obituaries->lastPage(),
    //         //     "next_page_url" => $obituaries->nextPageUrl(),
    //         //     "prev_page_url" => $obituaries->previousPageUrl(),
    //         //     "from" => $obituaries->firstItem(),
    //         //     "to" => $obituaries->lastItem()
    //         // );

    //         if ($request['search_word']) {
    //             $search_results = $events
    //                 ->merge($newsAnnouncements)
    //                 ->merge($notifications);
    //                 //->merge($obituaries);


    //             $search_results_metadata = [
    //                 "total" => $search_results->count(),
    //             ];
    //         }


    //         $mergedData = [];
    //         //$metadata = [];

    //         if ($request['search_word']) {
    //             $mergedData[] = ['category' => 'Search Results', 'list' => $search_results];
    //             //$metadata['search_results_metadata'] = $search_results_metadata;
    //         }

    //         $mergedData[] = ['category' => 'Events', 'list' => $events];
    //         //$metadata['events_metadata'] = $events_metadata;

    //         $mergedData[] = ['category' => 'News & Announcements', 'list' => $newsAnnouncements];
    //         //$metadata['newsAnnouncements_metadata'] = $newsAnnouncements_metadata;

    //         $mergedData[] = ['category' => 'Notifications', 'list' => $notifications];
    //         //$metadata['notifications_metadata'] = $notifications_metadata;

    //         //$mergedData[] = ['category' => 'Obituaries', 'list' => $obituaries];
    //         //$metadata['VicarMessages_metadata'] = $VicarMessages_metadata;

    //         return $this->outputer->code(200)
    //         //->metadata($metadata)
    //                     ->success($mergedData)->json();

    //     }catch (\Exception $e) {

    //         $return['result']=$e->getMessage();
    //         return $this->outputer->code(422)->error($return)->json();
    //     }
    // }


    public function DailyDigest(Request $request){
        try {

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

            $login_user = FamilyMember::select('id','name','image','family_id')
                            ->where('id',Auth::user()->id)->first();
            if ($login_user) {
                if ($login_user->image !== null) {
                    $login_user->image = asset('/') . $login_user->image;
                }
            }

            $bible_verse = BibleVerse::select('id','verse as heading','ref as sub_heading',DB::raw('"Bible Verse" as hash_value'))
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1)->first();
            if (!$bible_verse) {
                $random_verse = BibleVerse::select('id', 'verse as heading', 'ref as sub_heading',DB::raw('"Bible Verse" as hash_value'))
                        ->where('status', 1)
                        ->inRandomOrder()
                        ->first();
    
                $bible_verse = $random_verse ?? ['id' => null, 'heading' => 'Default Heading', 'sub_heading' => 'Default Subheading','hash_value'=>'Bible Verse'];
            }

            /*---------Daily Schedules Details----------*/

            $memoryData = MemoryDay::select('id',DB::raw('"ഓർമ" as heading'), 'title as sub_heading', 
                DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'), 
                DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'),DB::raw('"ഓർമ" as hash_value'),DB::raw('"null" as time'),)
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1); 

            $bibleCitationData = BiblicalCitation::select('id',DB::raw('"വേദഭാഗങ്ങൾ" as heading'), 'reference as sub_heading',
              DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),
               DB::raw('"null" as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'),DB::raw('"വേദഭാഗങ്ങൾ" as hash_value'),DB::raw('"null" as time'),)
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1); 

            $church_activities = DailySchedules::select('id',DB::raw('"തിരുകർമ്മങ്ങൾ" as heading'),'Title as sub_heading', 
                DB::raw('IFNULL(DATE_FORMAT(date, "%d/%m/%Y"), "' . $todayFormatted . '") as date'), 
                DB::raw('"null" as image'),'venue as type',DB::raw('"True" as color'), 
                DB::raw('"null" as link'),DB::raw('"തിരുകർമ്മങ്ങൾ" as hash_value'), DB::raw('DATE_FORMAT(time, "%h:%i %p") as time'))
                ->whereDate('date',$today_string)
                ->where('status', 1); 

            $churchActivitiesData = $church_activities;

            $daily_schedules = $bibleCitationData->union($churchActivitiesData)
                                ->union($memoryData)
                                ->get();
            $daily_schedules->transform(function ($item, $key) {

                if ($item->image !== 'null') {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

             /*---------Vicar Messages----------*/

            $Vic_messages = VicarMessage::select('id','subject as heading','message_body as sub_heading',
                           DB::raw('DATE_FORMAT(NOW(), "%d/%m/%Y") as date'))
                        ->addSelect('image',DB::raw('"Vicar Messages" as type'),DB::raw('"False" as color'),
                         DB::raw('"null" as link'),DB::raw('"Vicar messages" as hash_value'))
                        ->where('status',1);

            if($request['search_word']){
                $Vic_messages->where('subject','like',$request['search_word'].'%')
                            ->orwhere('message_body','like',$request['search_word'].'%');
            }

            $Vic_messages=$Vic_messages->orderBy('updated_at','desc')->get();

            $Vic_messages->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            if(empty($Vic_messages)) {
                $return['result']=  "Empty messages list ";
                return $this->outputer->code(422)->error($return)->json();
            }


            /*---------Obituaries Details----------*/


            $obituary = Obituary::select('id','name_of_member as heading')
                        ->selectSub(function ($query) {
                            $query->select('families.family_name')
                                ->from('family_members')
                                ->join('families', 'family_members.family_id', '=', 'families.id')
                                ->whereColumn('family_members.id', 'obituaries.member_id')
                                ->limit(1);
                        }, 'sub_heading')
                        ->addSelect('date_of_death as date','photo as image',DB::raw('"Obituaries" as type'),DB::raw('"False" as color'),'member_id', DB::raw('"null" as link'),'display_till_date',DB::raw('"Obituaries" as hash_value'))
                         ->whereDate('date_of_death', '<=', now())
                        ->whereDate('display_till_date', '>=', now())
                        ->where('status',1);

            if($request['search_word']){
                $obituary->where('subject','like',$request['search_word'].'%')
                            ->orwhere('message_body','like',$request['search_word'].'%');

            }

            $obituary=$obituary->orderBy('date_of_death','desc')->orderBy('display_till_date','desc')
                                ->get();
            $obituary->transform(function ($item, $key) {

                if ($item->image !== null) {
                     $item->image = asset('/') . $item->image;
                }
                return $item;
            });

            if(empty($obituary)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }
    
            /*---------Events Details----------*/

            $events = Event::select('id','event_name as sub_heading','venue as heading','date','image',
                DB::raw('"Events" as type'),DB::raw('"False" as color'),DB::raw('"Events" as hash_value'),
                'link','time','details')
                ->where('status',1);
            if($request['search_word']){
                $events->where('event_name','like',$request['search_word'].'%')
                        ->orwhere('venue','like',$request['search_word'].'%')
                        ->orwhere('details','like',$request['search_word'].'%');
            }

            $events=$events->orderBy('id', 'desc')->get();

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


            /*---------News & Announcements Details----------*/

            $newsAnnouncements = NewsAnnouncement::select('id','updated_at as date','heading as sub_heading',
                'type_name as heading')
                ->addSelect('body as details','image','type as type' ,'group_org_id',
                    DB::raw('"News & Announcements" as type1'),DB::raw('"False" as color'),'type_name as hash_value','link')
                ->where('status',1);
            if($request['search_word']){

                $searchTerm = strtolower($request['search_word']);
                $newsAnnouncements->where(function ($query) use ($searchTerm) {
                    $query->where('heading', 'like', '%' . $searchTerm . '%')
                        ->orWhere('type_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('body', 'like', '%' . $searchTerm . '%');
                });
            }

            $newsAnnouncements=$newsAnnouncements->orderBy('id', 'desc')->get();

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

            /*---------Notifications Details----------*/

            $notifications = Notification::select('id','updated_at as date','title as sub_heading','type_name as heading')

            ->addSelect('content as details','group_org_id','type',
                DB::raw('"Notifications" as type_value'),DB::raw('"False" as color'),'type_name as hash_value',
                DB::raw('"null" as link'))

            ->where('status',1);

            if($request['search_word']){

                $searchTerm = strtolower($request['search_word']);
                $notifications->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('type_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('content', 'like', '%' . $searchTerm . '%');
                });
                switch ($searchTerm) {
                    case 'trustee':
                        $notifications->where('type', 1);
                        break;
                    case 'secretary':
                        $notifications->where('type', 2);
                        break;
                    case 'prayer group':
                        $notifications->where('type', 3);
                        break;
                    case 'organization':
                        $notifications->where('type', 4);
                        break;
                }
            }

            $notifications=$notifications->orderBy('id', 'desc')->get();

            $notifications->transform(function ($notif) {
                $notif->image = null;
                return $notif;
            });
            if(empty($notifications)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $mergedData = [

                [ 'category' => 'Daily Schedules', 'list' => $daily_schedules ],

                [ 'category' => 'Vicar Messages', 'list' => $Vic_messages ],

                [ 'category' => 'Obituary', 'list' => $obituary ],

                [ 'category' => 'Events', 'list' => $events ],

                [ 'category' => 'News & Announcement', 'list' => $newsAnnouncements ],

                [ 'category' => 'Notifications', 'list' => $notifications ],
               
            ];

            return $this->outputer->code(200)
                        ->success($mergedData )
                        ->DailyDigest($bible_verse)
                        ->LoginUser($login_user)
                        ->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }
}
