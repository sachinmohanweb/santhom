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
use App\Models\PrayerMeeting;

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
            $per_pg='100';

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
            $per_pg='100';

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
            $per_pg='15';
            $family_id = Auth::user()->family_id;
            $member_id = Auth::user()->id;


            $payments = PaymentDetail::select('payment_details.id',
                    'payment_details.amount','payment_details.category_id','payment_details.family_id',
                    'payment_details.family_head_id',DB::raw('"null" as date'))
                    ->join('family_members', 'payment_details.family_head_id', '=', 'family_members.id')
                    ->where('family_members.family_id', $family_id)
                    ->where('payment_details.status', 1);
            $payments_sum = $payments->sum('payment_details.amount');
            $family = Family::select('id','family_code','family_name')->find($family_id);

            $payments=$payments->orderBy('payment_details.id')->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($payments)) {
                $return['result']=  "Empty payments list ";
                return $this->outputer->code(422)->error($return)->json();
            }else{

                $date_value = PaymentDetail::first();
                if($date_value){
                    $result['date'] = $date_value['date'];
                }
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
            }
            

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function Notifications(Request $request){

        try {

            $pg_no='';
            $per_pg='100';

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
                        ->where('status',1)
                        ->whereHas('family', function ($query) {
                            $query->where('status', 1);
                        });
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
                    ->where('status',1)
                    ->whereHas('family', function ($query) {
                            $query->where('status', 1);
                    });

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
            $response_data = [
                'organization' => $request['organization'],
                'no_of_employees' => count($org_members),
                'employees' => $org_members
            ];
            return $this->outputer->code(200)->success($response_data)->json();
        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function YearlyCalenderEvents(Request $request) {
        try {
            $currentYear = date("Y");
            $currentMonth = date('n');

            $data = [];
            $monthsToFetch = 6;
            
            for ($i = 0; $i < $monthsToFetch; $i++) {
                $month = $currentMonth + $i;
                $year = $currentYear;

                // Handle year rollover if month exceeds 12
                if ($month > 12) {
                    $month -= 12;
                    $year += 1;
                }

                for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++) {

                    $readings = BiblicalCitation::whereMonth('date', $month)
                        ->whereDay('date', $day)
                        ->where('status', 1)
                        ->count();

                    $birthdays = FamilyMember::whereMonth('dob', $month)
                        ->whereDay('dob', $day)
                        ->whereNull('date_of_death')
                        ->where('status', 1)
                        ->whereHas('family', function ($query) {
                            $query->where('status', 1);
                        })
                        ->count();

                    $wedding_anniversaries = FamilyMember::whereMonth('date_of_marriage', $month)
                        ->whereDay('date_of_marriage', $day)
                        ->whereNull('date_of_death')
                        ->where('status', 1)
                        ->whereHas('family', function ($query) {
                            $query->where('status', 1);
                        })
                        ->count();

                    $obituaries = Obituary::whereMonth('date_of_death', $month)
                        ->whereDay('date_of_death', $day)
                        ->where('status', 1)
                        ->count();

                    $total_events = $readings + $birthdays + $wedding_anniversaries + $obituaries;

                    $data[] = [
                        'date' => sprintf('%02d-%02d-%02d', $day, $month, $year),
                        'total_events' => $total_events
                    ];
                }
            }

            return $this->outputer->code(200)->success($data)->json();
        } catch (\Exception $e) {
            $return['result'] = $e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function DailyCalenderEvents(Request $request){

        try {

            $date=date("d-m-Y");
            if($request['date']){
                $date = $request['date'];
            }

            /*---------Daily reading Details----------*/

                $daily_readings = BiblicalCitation::select('id','reference as heading','note1 as sub_heading',
                    DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),
                    DB::raw('JSON_ARRAY(NULL) as image'),
                    DB::raw('"Daily Readings" as hash_value'),'note2 as details')
                                ->whereRaw("DATE_FORMAT(date, '%Y-%m-%d') = DATE_FORMAT('$date', '%Y-%m-%d')")
                                ->where('status', 1)
                                ->orderBy('reference', 'asc');

                $daily_readings=$daily_readings->orderBy('id', 'desc')->get();

                $daily_readings->transform(function ($item, $key) {
                    if ($item->image === '[null]') {
                        $item->image = [null];
                    }
                    return $item;
                });

            /*---------Birthdays Details----------*/

                $birthdays = FamilyMember::select('id',DB::raw('CONCAT("Happy birthday dear ", name) as heading'),)
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_heading'))
                        ->addSelect(DB::raw('DATE_FORMAT(dob, "%d/%m/%Y") as date'),'image as image','family_id',DB::raw('"Birthdays" as hash_value'),
                            'mobile as details')
                                ->whereRaw("DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                                ->whereRaw("DATE_FORMAT(dob, '%Y') != DATE_FORMAT('$date', '%Y')")
                                ->where('status', 1)
                                ->whereHas('family', function ($query) {
                                    $query->where('status', 1);
                                })
                                ->whereNull('date_of_death')
                                ->orderBy('name', 'asc');

                $birthdays=$birthdays->orderBy('id', 'desc')->get();
                $birthdays->makeHidden(['family_name', 'family_head_name','prayer_group_name','marital_status_name',
                            'relationship_name','obituary_id','blood_group_name']);
                

                $birthdays->transform(function ($item, $key) {

                    if ($item->image !== null) {
                        $item->image = [asset('/') . $item->image];
                    } else {
                        $item->image = [null];
                    }
                    return $item;
                });

            /*---------Wedding Anniversary Details----------*/


                $weddings = FamilyMember::select('id', 'name', 'image', 'date_of_marriage', 'family_id')
                    ->whereRaw("DATE_FORMAT(date_of_marriage, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                    ->whereRaw("DATE_FORMAT(date_of_marriage, '%Y') != DATE_FORMAT('$date', '%Y')")
                    ->where('status', 1)
                    ->whereHas('family', function ($query) {
                        $query->where('status', 1);
                    })
                    ->whereNull('date_of_death')
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
                            'type' => $type,
                            'details'=>null
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
                            'type' => $type,
                            'details'=>null
                        ];
                    }

                    $finalWeddings->push($item);
                }

                $finalWeddings->transform(function ($item, $key) {
                    if (isset($item['image']) && $item['image'] !== null) {
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


            /*---------Death Anniversary Details----------*/

                // $obituary = Obituary::select('id',DB::raw('CONCAT("Death anniversary of ", name_of_member) as heading'))
                //    ->selectSub(function ($query) {
                //         $query->select('families.family_name')
                //             ->from('family_members')
                //             ->join('families', 'family_members.family_id', '=', 'families.id')
                //             ->whereColumn('family_members.id', 'obituaries.member_id')
                //             ->limit(1);
                //     }, 'sub_heading')
                //     ->addSelect(DB::raw('DATE_FORMAT(date_of_death, "%d/%m/%Y") as date'),'photo as image',
                //         DB::raw('"Death Anniversary" as hash_value'),DB::raw('"null" as details'))

                //     ->whereRaw("DATE_FORMAT(date_of_death, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                //     ->whereRaw("DATE_FORMAT(date_of_death, '%Y') != DATE_FORMAT('$date', '%Y')")
                //     ->where('status',1)
                //     ->orderByRaw("DAY(date_of_death) ASC")
                //     ->orderBy('date_of_death', 'asc');

                // $obituary=$obituary->orderBy('id', 'desc')->get();


                // $obituary->transform(function ($item, $key) {

                //     if ($item->image !== null) {
                //         $item->image = [asset('/') . $item->image];
                //     } else {
                //         $item->image = [];
                //     }
                //     return $item;
                // });

             /*---------Death Anniversary Details----------*/

                $death_anniversary = FamilyMember::select('id',DB::raw('CONCAT("Death anniversary of ", name) as heading'))
                        ->addSelect(DB::raw('(SELECT family_name FROM families WHERE families.id = family_members.family_id) AS sub_heading'))
                        ->addSelect(DB::raw('DATE_FORMAT(date_of_death, "%d/%m/%Y") as date'),'image as image','family_id',DB::raw('"Death Anniversary" as hash_value'),'relationship_id')
                                ->whereRaw("DATE_FORMAT(date_of_death, '%m-%d') = DATE_FORMAT('$date', '%m-%d')")
                                ->whereRaw("DATE_FORMAT(date_of_death, '%Y') != DATE_FORMAT('$date', '%Y')")
                                ->where('status', 1)
                                ->whereHas('family', function ($query) {
                                    $query->where('status', 1);
                                })
                                ->orderBy('name', 'asc');

                $death_anniversary=$death_anniversary->orderBy('id', 'desc')->get();
                $death_anniversary->makeHidden(['family_name', 'family_head_name','prayer_group_name','marital_status_name',
                            'relationship_name','obituary_id','blood_group_name']);
                

                $death_anniversary->transform(function ($item, $key) {

                    if ($item->image !== null) {
                        $item->image = [asset('/') . $item->image];
                    } else {
                        $item->image = [null];
                    }
                    $item->details = $item->relationship_name.' of '.$item->family_head_name;
                    return $item;
                });



            $total = $birthdays->count() + $finalWeddings->count() + $daily_readings->count() + $death_anniversary->count();

            $mergedData = [
                'number_of_events' => $total,
                'events' => [
                    [
                        'type' => 'Daily Readings',
                        'list' => $daily_readings
                    ],
                    [
                        'type' => 'Birthdays',
                        'list' => $birthdays
                    ],
                    [
                        'type' => 'Wedding Anniversary',
                        'list' => $finalWeddings
                    ],
                    [
                        'type' => 'Death Anniversary',
                        'list' => $death_anniversary
                    ],
                ]
            ];

            return $this->outputer->code(200)->success($mergedData)->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function DailyDigest(Request $request){
        try {

            $today= now();
            $day = $today->format('d');
            $month = $today->format('m');
            $monthDay = $today->format('m-d');
            $today_string = now()->toDateString();
            $todayFormatted = date('d/m/Y');

            $tomorrow = $today->addDay()->format('Y-m-d');

            if($today->hour >= 20) {
                $dateCondition = $tomorrow;
            }else{
                $dateCondition = $today_string;
            }
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
                DB::raw('JSON_ARRAY(NULL) as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'),DB::raw('"ഓർമ" as hash_value'),DB::raw('"null" as time'),'note1 as details1','note2 as details2',DB::raw('"null" as details3'))
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1); 

            $bibleCitationData = BiblicalCitation::select('id',DB::raw('"വേദഭാഗങ്ങൾ" as heading'), 'reference as sub_heading',
              DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),
                DB::raw('JSON_ARRAY(NULL) as image'),DB::raw('"Daily Schedules" as type'),DB::raw('"True" as color'), DB::raw('"null" as link'),DB::raw('"വേദഭാഗങ്ങൾ" as hash_value'),DB::raw('"null" as time'),'note1 as details1','note2 as details2',DB::raw('"null" as details3'))
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today_string', '%m-%d')")
                ->where('status', 1); 

             $church_activities = DailySchedules::select('id','title as heading','venue as sub_heading', 
                DB::raw('IFNULL(DATE_FORMAT(date, "%d/%m/%Y"), "' . $todayFormatted . '") as date'), 
                DB::raw('JSON_ARRAY(NULL) as image'),DB::raw('"തിരുകർമ്മങ്ങൾ" as hash_value'), 
                DB::raw('"null" as link'),'venue as type',DB::raw('"False" as color'), 
                DB::raw('DATE_FORMAT(time, "%h:%i %p") as time'),'details as details1',
                DB::raw('DATE_FORMAT(time, "%h:%i %p") as details2'),DB::raw('"null" as details3'))
                ->whereDate('date',$dateCondition)
                ->where('status', 1);

            $churchActivitiesData = $church_activities;
            $churchActivitiesGetData = $church_activities
                                        ->orderByRaw('TIME(time)')
                                        ->get();

            $daily_schedules = $bibleCitationData->union($memoryData)
                                ->union($churchActivitiesData)
                                ->orderByRaw('STR_TO_DATE(time, "%h:%i %p")')
                                ->get();

            $allDetails2 = $churchActivitiesGetData->map(function ($item) {
                return $item->time . "\n" . $item->sub_heading . "\n" . $item->details1."\n";
            })->toArray();

            $combinedDetails2 = implode("\n", $allDetails2);

            $daily_schedules->transform(function ($item, $key) use ($combinedDetails2) {
                if ($item->image === '[null]') {
                    $item->image = [];
                }
                if ($item->type === 'തിരുകർമ്മങ്ങൾ') {
                    $item->details2 = $combinedDetails2;
                    $item->link = null;
                }
                return $item;
            });            

             /*---------Vicar Messages----------*/

            $Vic_messages = VicarMessage::select('id','subject as heading','message_body as sub_heading',
                           DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as date'))
                        ->addSelect('image',DB::raw('"Vicar Messages" as type'),DB::raw('"False" as color'),
                         DB::raw('"null" as link'),DB::raw('"Vicar messages" as hash_value'),DB::raw('"null" as time'),DB::raw('"null" as details1'),DB::raw('"null" as details2'),DB::raw('"null" as details3'))
                        ->where('status',1);

            if($request['search_word']){
                $Vic_messages->where('subject','like',$request['search_word'].'%')
                            ->orwhere('message_body','like',$request['search_word'].'%');
            }

            $Vic_messages=$Vic_messages->orderBy('updated_at','desc')->get();

            $Vic_messages->transform(function ($item, $key) {

                if ($item->image !== null) {
                    $item->image = [asset('/') . $item->image];
                } else {
                    $item->image = [];
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
                        ->addSelect(DB::raw('DATE_FORMAT(date_of_death, "%d/%m/%Y") as date'),'photo as image',DB::raw('"Obituaries" as type'),DB::raw('"False" as color'), DB::raw('"null" as link'),DB::raw('"Obituaries" as hash_value'),
                            // 'funeral_time as time',
                            'funeral_time','member_id',
                            DB::raw('CONCAT("Funeral date: ", DATE_FORMAT(funeral_date, "%d/%m/%Y")) as details1'),'notes as details3'
                        )
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

                if ($item->funeral_time !== null) {
                     $item->details2 = 'Funeral Time : '.$item->time;
                }
                return $item;
            });
            
            $obituary->transform(function ($item, $key) {

                if ($item->image !== null) {
                    $item->image = [asset('/') . $item->image];
                } else {
                    $item->image = [];
                }
                return $item;
            });
            if(empty($obituary)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }
    
            /*---------Events Details----------*/

            $events = Event::select('id','event_name as heading','venue as sub_heading',
                DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),'image as img1','image2 as img2',
                DB::raw('"Events" as type'),DB::raw('"False" as color'),DB::raw('"Events" as hash_value'),'details as details1',
                DB::raw('"null" as details2'),'link','time_value',DB::raw('"null" as details3'))
                ->where('events.date', '>', now()->subDay()->format('Y-m-d'))
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

                $images = [];

                if ($item->img1 !== null) {
                     $images[] = asset('/') . $item->img1;
                }
                if ($item->img2 !== null) {
                     $images[] = asset('/') . $item->img2;
                }
                $item->image = $images;
                unset($item->img1,$item->img2);
                return $item;
            });
            $events->makeHidden([ 'image_1_name', 'image_2_name']);


            /*---------News & Announcements Details----------*/

            $newsAnnouncements = NewsAnnouncement::select('id',
                    DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as date'),
                    'heading as heading',DB::raw('"null" as sub_heading'))
                ->addSelect('image','image2','type as type' ,'group_org_id',
                    DB::raw('"News & Announcements" as type1'),DB::raw('"False" as color'),'type_name as hash_value','link',DB::raw('"null" as time'),'body as details1',DB::raw('"null" as details2'),DB::raw('"null" as details3'))
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

                $images = [];

                if ($item->image !== null) {
                    $images[] = asset('/') . $item->image;
                }
                if ($item->image2 !== null) {
                    $images[] = asset('/') . $item->image2;
                }
                unset($item->image,$item->image2);
                $item->image = $images;

                if($item->group_organization_name !=='Nill'){

                    $item->sub_heading = $item->group_organization_name;
                }else{
                    $item->sub_heading = $item->hash_value;

                }

                return $item;
            });

            $newsAnnouncements->makeHidden([ 'image_1_name', 'image_2_name']);


            /*---------Notifications Details----------*/

            $notifications = Notification::select('id',DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as date'),'title as heading',
                DB::raw('"null" as sub_heading'),'group_org_id','type')
            ->addSelect(DB::raw('"Notifications" as type_value'),DB::raw('"False" as color'),DB::raw('"Notifications" as hash_value'),
                DB::raw('"null" as link'),DB::raw('"null" as time'),'content as details1',DB::raw('"null" as details2'),DB::raw('"null" as details3'))

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
                $images = [];
                $notif->image = $images;

                if($notif->group_organization_name !=='Nill'){

                    $notif->sub_heading = $notif->group_organization_name;
                }else{
                    $notif->sub_heading = $notif->type;

                }
                return $notif;
            });
            if(empty($notifications)) {
                $return['result']=  "Empty prayer group list ";
                return $this->outputer->code(422)->error($return)->json();
            }



            /*---------Prayer Meetings Details----------*/

            $prayer_meetings = PrayerMeeting::select('prayer_meetings.id','prayer_groups.group_name as heading','families.family_name as sub_heading'
                ,DB::raw('DATE_FORMAT(date, "%d/%m/%Y") as date'),
                DB::raw('"Prayer Meetings" as type_value'),DB::raw('"False" as color'), DB::raw('"null" as link'),DB::raw('"null" as details2'),'families.map_location as details1',DB::raw('"null" as details3'))
                ->leftJoin('prayer_groups', 'prayer_meetings.prayer_group_id', '=', 'prayer_groups.id')
                ->leftJoin('families', 'prayer_meetings.family_id', '=', 'families.id')
                ->where('prayer_meetings.date', '>', now()->subDay()->format('Y-m-d'))
                ->orderBy('prayer_meetings.date')
                ->where('prayer_meetings.status', 1);

            if($request['search_word']){

                $searchTerm = strtolower($request['search_word']);
                // $prayer_meetings->where(function ($query) use ($searchTerm) {
                //     $query->where('heading', 'like', '%' . $searchTerm . '%')
                //         ->orWhere('type_name', 'like', '%' . $searchTerm . '%')
                //         ->orWhere('body', 'like', '%' . $searchTerm . '%');
                // });
            }

            $prayer_meetings=$prayer_meetings->orderBy('id', 'desc')->get();

            if(empty($prayer_meetings)) {
                $return['result']=  "Empty marital status list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $prayer_meetings->transform(function ($item, $key) {

                $images = [];

                if ($item->image !== null) {
                    $images[] = asset('/') . $item->image;
                }
                if ($item->image2 !== null) {
                    $images[] = asset('/') . $item->image2;
                }
                unset($item->image,$item->image2);
                $item->image = $images;
                return $item;
            });


            $mergedData = [

                [ 'category' => 'Daily Schedule', 'list' => $daily_schedules ],

                [ 'category' => "Vicar’s message", 'list' => $Vic_messages ],

                [ 'category' => 'Obituary', 'list' => $obituary ],

                [ 'category' => 'Events', 'list' => $events ],

                [ 'category' => 'News & Announcements', 'list' => $newsAnnouncements ],

                [ 'category' => 'Notifications', 'list' => $notifications ],

                //[ 'category' => 'Prayer Meetings', 'list' => $prayer_meetings ],
               
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
