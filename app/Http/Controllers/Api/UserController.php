<?php

namespace App\Http\Controllers\Api;

use DB;
use Mail;
use Auth;
use Carbon\Carbon;

use App\Models\Family;
use App\Models\VicarDetail;
use App\Models\FamilyMember;
use App\Models\EmailVerification;

use App\Mail\UserVerificationMail;
use App\Http\Repositories\UserRepository;

use App\Helpers\Outputer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

use App\Http\Controllers\Controller;
class UserController extends Controller
{
    public function __construct(Outputer $outputer,UserRepository $userRepo){

        $this->outputer = $outputer;
        $this->userRepo = $userRepo;
    }

    public function loginUser(Request $request){

        DB::beginTransaction();

        try {
            $family = $this->userRepo->checkUser($request->all());

            if(empty($family)) {
                $return['result']=  "Invalid/Incorrect Family Code or Email.";
                return $this->outputer->code(422)->error($return)->json();
            }else{
                $otp = mt_rand(1000, 9999);

                $inputData['email'] = $request['email'];
                $inputData['otp'] = $otp;
                $inputData['otp_expiry'] = Carbon::now()->addMinutes(5);

                EmailVerification::create($inputData);
                DB::commit();

                $member = FamilyMember::where('email',$request->input('email'))->first();
                
                $mailData = [
                    'member' => $member,
                    'otp' => $otp,
                ];

                Mail::to($request->input('email'))->send(new UserVerificationMail($mailData));

                $return['messsage']  =  'OTP sent to your email';
                return $this->outputer->code(200)->success($return)->json();
            }

        }catch (\Exception $e) {

            DB::rollBack();
            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function VerifyOtp(Request $request){

        DB::beginTransaction();

        try {
            
            $otp = EmailVerification::where('email', $request->email)
                ->where('otp', $request->otp)
                ->where('otp_used', false)
                ->first();

            if ($otp) {

                if (Carbon::now()->lt($otp->otp_expiry)) {
                    $otp->otp_used = true;
                    $otp->save();
                    DB::commit();

                    $user = $this->userRepo->emailFamilyMember($request->email);
                    if ($user->image !== null) {
                        $user->image = asset('/') . $user->image;
                    } else {
                        $user->image = null;
                    }

                    Auth::guard('member')->login($user);

                    $token = $user->createToken('santhom-mobile-app')->plainTextToken;

                    $return['messsage']  =  'OTP verified successfully';
                    $return['token']  = $token;
                    $return['user']  =  $user;

                    return $this->outputer->code(200)->success($return)->json();
                }else{
                    $return['messsage']  =  'OTP Expired';
                    return $this->outputer->code(422)->error($return)->json();
                }
            }else{

                $return['messsage']  =  'Invalid OTP';
                return $this->outputer->code(422)->error($return)->json();
            }

        }catch (\Exception $e) {

            DB::rollBack();
            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function myprofile(){

        $member = FamilyMember::find(Auth::user()->id);

        if ($member->image !== null) {
            $member->image = asset('/') . $member->image;
        } else {
           $member->image = null; 
        }

        $return['member']  =  $member;

        return $this->outputer->code(200)->success($return)->json();
    }

    public function updateFamily(Request $request,$family_id){
        DB::beginTransaction();

        try {

            $family = Family::find($family_id);
            
            $a =  $request->validate([
                'family_name' => 'required',
                'prayer_group_id' => 'required',
                'address1' => 'required',
                'pincode' => 'required',
                ]);

            $inputData = $request->all();
            $inputData['status'] = 2;


            $family->update($inputData);
            DB::commit();

            $return['messsage']  =  'success';
            $return['family']  =  $family;
            return $this->outputer->code(200)->success($return)->json();


        }catch (\Exception $e) {

            DB::rollBack();
            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function myfamily(){

        $family = Family::where('id',Auth::user()->family_id)->first();
        $members = FamilyMember::where('family_id',Auth::user()->family_id)->get();

        foreach ($members as $member) {
            if ($member->image !== null) {
                $member->image = asset('/') . $member->image;
            } else {
                $member->image = null;
            }
        }

        $return['family']  =  $family;
        $return['members']  =  $members;

        return $this->outputer->code(200)->success($return)->json();
    }

    public function addMember(Request $request){
        DB::beginTransaction();

        try {


            $a =  $request->validate([
                'name'      => 'required',
                'family_id' => 'required',
                'gender'    => 'required',
                'dob'       => 'required',
                'relationship_id'   => 'required',

                ]);

            $inputData = $request->all();
            $inputData['status'] = 2;

            if($request['image']){

                $fileName = str_replace(' ', '_', $request->name).'.'.$request['image']->extension();
                $request->image->storeAs('members', $fileName);
                $inputData['image'] = 'storage/members/'.$fileName;
            }

            $member = FamilyMember::create($inputData);
            DB::commit();

            $return['messsage']  =  'success';
            $return['family']  =  $member;
            return $this->outputer->code(200)->success($return)->json();


        }catch (\Exception $e) {

            DB::rollBack();
            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function updateMember(Request $request,$member_id){
        DB::beginTransaction();

        try {

            $member = FamilyMember::find($member_id);

            $a =  $request->validate([
                'name'      => 'required',
                'family_id' => 'required',
                'gender'    => 'required',
                'dob'       => 'required',
                'relationship_id'   => 'required',

                ]);

            $inputData = $request->all();
            $inputData['status'] = 2;

            if($request['image']){

                $fileName = str_replace(' ', '_', $request->name).'.'.$request['image']->extension();
                $request->image->storeAs('members', $fileName);
                $inputData['image'] = 'storage/members/'.$fileName;
            }


            $member->update($inputData);
            DB::commit();

            $return['messsage']  =  'success';
            $return['family']  =  $member;
            return $this->outputer->code(200)->success($return)->json();


        }catch (\Exception $e) {

            DB::rollBack();
            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function family(Request $request){

        $family = Family::where('id',$request['id'])->first();
        $members = FamilyMember::select('id','name','relationship_id','family_id')
                        ->where('family_id',$request['id'])->get();

        foreach ($members as $member) {
            if ($member->image !== null) {
                $member->image = asset('/') . $member->image;
            } else {
                $member->image = null;
            }
        }

        $return['family']  =  $family;
        $return['members']  =  $members;

        return $this->outputer->code(200)->success($return)->json();
    }

    public function familyMember(Request $request){

        $member = FamilyMember::find($request['id']);
        if($member){

            if ($member->image !== null) {
                $member->image = asset('/') . $member->image;
            } else {
               $member->image = null; 
            }
        }

        $return['member']  =  $member;

        return $this->outputer->code(200)->success($return)->json();
    }

    public function logoutuser(){

        DB::beginTransaction();

        try {

            $user=Auth::user();
            $currentToken = $user->currentAccessToken();

            if ($currentToken) {
                $currentToken->delete();
            }
            
            DB::commit();

            $return['messsage']  =  'User Tokens deleted';
            return $this->outputer->code(200)->success($return)->json();

        }catch (\Exception $e) {

            DB::rollBack();
            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function VicarsList(Request $request){

        try {

            $pg_no='';
            $per_pg='';

            $vicars = VicarDetail::select('*')->where('status',1);

            if($request['search_word']){
                $vicars->where('name','like',$request['search_word'].'%')
                            ->orwhere('title','like',$request['search_word'].'%')
                            ->orwhere('family_name','like',$request['search_word'].'%');
            }
            if($request['page_no']){
                $pg_no=$page=$request['page_no'];
            }
            if($request['per_page']){
               $per_pg=$page=$request['per_page'];
            }
            $vicars=$vicars->paginate($perPage=$per_pg,[],'',$page = $pg_no);

            if(empty($vicars)) {
                $return['result']=  "Empty Vicars list ";
                return $this->outputer->code(422)->error($return)->json();
            }

            $metadata = array(
                "total" => $vicars->total(),
                "per_page" => $vicars->perPage(),
                "current_page" => $vicars->currentPage(),
                "last_page" => $vicars->lastPage(),
                "next_page_url" => $vicars->nextPageUrl(),
                "prev_page_url" => $vicars->previousPageUrl(),
                "from" => $vicars->firstItem(),
                "to" => $vicars->lastItem()
            );

            return $this->outputer->code(200)->metadata($metadata)
                        ->success($vicars->getCollection())->json();

        }catch (\Exception $e) {

            $return['result']=$e->getMessage();
            return $this->outputer->code(422)->error($return)->json();
        }
    }

    public function VicarDetails(Request $request){

        try {

            $vicar = VicarDetail::select('*')->where('id',$request['id'])->first();
            $personal_details = FamilyMember::select('family_members.id as member_id','family_members.gender','family_members.dob','family_members.email','family_members.image','families.family_code','families.family_name','families.address1','families.id as family_id')
                ->join('families', 'family_members.family_id', '=', 'families.id')
                ->where('family_members.id',$vicar['member_id'])->get();
                        
            $personal_details->transform(function ($item, $key) {
                if ($item->image !== null) {
                    $item->image = asset('/') . $item->image;
                }else {
                    $item->image = null; 
                }
                return $item;
            });

            $return['vicar']  =  $vicar;
            $return['personal_details']  =  $personal_details;

            return $this->outputer->code(200)->success($return)->json();    

            }catch (\Exception $e) {

                $return['result']=$e->getMessage();
                return $this->outputer->code(422)->error($return)->json();
            }
    }

}
