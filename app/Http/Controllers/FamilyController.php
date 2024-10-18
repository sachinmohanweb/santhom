<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use DB;
use Auth;
use Excel;
use Cache;
use Session;
use Exception;
use Datatables;

use App\Models\Family;
use App\Models\Obituary;
use App\Models\BloodGroup;
use App\Models\PrayerGroup;
use App\Models\VicarDetail;
use App\Models\FamilyMember;
use App\Models\Relationship;
use App\Models\Organization;
use App\Models\MaritalStatus;
use App\Models\PaymentDetail;
use App\Models\OrganizationOfficer;

use App\Imports\FamilyMemberImport;

class FamilyController extends Controller
{

    public function admin_family_list() : View
    {
        return view('user.family.index',[]);
    }
    public function admin_family_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(Family::select('*')->where('status','!=',  2))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('prayer_group', function ($family) {
                return $family->PrayerGroup->group_name;
            })
            ->addColumn('action', 'user.family.family-datatable-action')
            ->rawColumns(['action','prayer_group'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function admin_family_create() : View
    {
        $prayer_groups = PrayerGroup::all();
        return view('user.family.create',compact('prayer_groups'));
    }

    public function admin_family_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'family_code' => 'required|unique:families',
                'family_name' => 'required',
                'prayer_group_id' => 'required',
                'address1' => 'required',
                'pincode' => 'required',
            ], [
                'family_code.unique' => 'The :attribute already exists.',
            ]);

            $family = Family::create($request->all());
            DB::commit();
             
            return redirect()->route('admin.family.member.create.family_id',['family_id' => $family['id']])
                            ->with('success',"Success! Your family has been successfully added. Now, let's create a member profile for the head of the family.");
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function admin_family_show($id) : View
    {
        $family = Family::where('id',$id)->with('Members','PrayerGroup','HeadOfFamily')->first();
        $prayer_groups = PrayerGroup::all();
        return view('user.family.details',compact('family','prayer_groups'));
    }

    public function admin_family_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $family = Family::find($request->id);
            $a =  $request->validate([
                 'family_code' => 'required',
                'family_name' => 'required',
                'prayer_group_id' => 'required',
                'address1' => 'required',
                'pincode' => 'required',
            ]);

            $family_with_same_code = Family::where('id', '!=', $request->id)
                                    ->where('family_code',$request->family_code)->first();
            if($family_with_same_code){
                return back()->with('error','You can not use existing family code');

            }
            $family->update($request->all());
            DB::commit();

            return redirect()->back()
                    ->with('success','Family details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function admin_family_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $family_members =FamilyMember::where('family_id',$request->id)->first();
            if($family_members){
                $return['status'] = 'failed';
                Session::flash('error', 'This family has family members and cannot be deleted.');
            }else{
                $family = Family::where('id',$request->id)->delete();
                DB::commit();
                Session::flash('success', 'Family successfully deleted.');
                $return['status'] = "success";
            }

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Family deletion not success.');
        }
        return response()->json($return);
    }

    public function admin_family_block_unblock(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $family = Family::find($request['family_id']);
            if($family['status']==3){
                $family['status'] =1 ;
            }else{
                $family['status'] =3 ;
            }
            $family->save();
            DB::commit();
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Family deletion not success.');
        }
        return response()->json($return);
    }

    public function admin_family_members_list() : View
    {
        return view('user.members.index');
    }
    public function admin_family_members_Datatable()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(FamilyMember::select('*')->where('status',1)->whereNull('date_of_death')->where('user_type',1)
            ->with('family','relationship'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('image', function ($familyMember) {

                if ($familyMember->image) {
                    return '<img  class="img-70 rounded-circle" src="' . asset($familyMember->image) . '"  alt="Family Member Image" style="height: 70px;">';
                } else {
                    $nameWords = explode(' ', $familyMember->name);
                    $nameLetters = '';

                    foreach ($nameWords as $word) {
                        $nameLetters .= substr($word, 0, 1);
                        if(strlen($nameLetters) >= 2) {
                            break;
                        }
                    }

                    if(strlen($nameLetters) == 1) {
                        //$nameLetters = substr($this->name, 0, 2);
                        $nameLetters = $nameLetters;
                    }

                    $backgroundColors = ['#ff7f0e', '#2ca02c', '#1f77b4', '#d62728', '#9467bd'];
                    $backgroundColor = $backgroundColors[array_rand($backgroundColors)];

                    return '<div class="img-70 rounded-circle text-center" style="height: 70px; width: 70px; background-color: ' . $backgroundColor . '; color: white; line-height: 70px; font-size: 24px;">' . $nameLetters . '</div>';
                }
            })
            ->addColumn('dob', function ($familyMember) {
                return date("d/m/Y", strtotime($familyMember->dob));
            })
            ->addColumn('family_name', function ($familyMember) {
                return $familyMember->family->family_name;
            })
            ->addColumn('relationship', function ($familyMember) {
                return $familyMember->relationship->relation_name;
            })
           
            ->addColumn('action', 'user.members.family-members-datatable-action')
            ->rawColumns(['image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function admin_family_member_create($family_id = null) : View
    {   

        $familys = Family::all();
        $relations = Relationship::all();
        $blood_groups = BloodGroup::all();
        $marital_statuses = MaritalStatus::all();
        $titles = ['Mr', 'Ms', 'Mrs', 'Fr', 'Sr', 'Dr', 'Adv', 'Engg'];
        return view('user.members.create',compact('familys','blood_groups','marital_statuses','relations','family_id','titles'));
    }

    public function admin_family_member_store(Request $request): RedirectResponse
    {

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

            $head = FamilyMember::where('family_id',$request['family_id'])
                                ->where('head_of_family',1)->first();
            if($head && $request['relationship_id']==1){

                return back()->withInput()->withErrors(['message' =>  "Already added head of the family"]);;
            }
            if($request['marr_memb_id']){
                $old_married_person = FamilyMember::where('marr_memb_id',$request['marr_memb_id'])->first();
                if($old_married_person){
                    $details['remark'] = null;
                    $details['marr_memb_id'] = null;
                    $old_married_person->update($details);
                }
            }

            if($request['image']){

                $fileName = str_replace(' ', '_', $request->name).'_'.time().'.'.$request['image']->extension();

                if($request['date_of_death']){
                    $request->image->storeAs('obituary', $fileName);
                    $inputData['image'] = 'storage/obituary/'.$fileName;
                }else{

                    $request->image->storeAs('members', $fileName);
                    $inputData['image'] = 'storage/members/'.$fileName;
                }
            }
            if($request['relationship_id']==1){ 
                $inputData['head_of_family'] = '1';
            }
            $member_same_mail = FamilyMember::where('family_id',$request['family_id'])
                                ->where('email',$request['email'])->first();
            if($member_same_mail){
                $inputData['email'] = null;
            }

            $member = FamilyMember::create($inputData);

            if($request['marr_memb_id']){

                $updat_married_to = FamilyMember::where('id',$request['marr_memb_id'])->first();
                $details['remark'] = 1;
                $details['marr_memb_id'] = $member->id;
                $updat_married_to->update($details);
            }

            if($request['date_of_death']){
                $today = date('Y-m-d');
                if($request['date_of_death']== $today){
                    $inputData1['member_id'] = $member->id;
                    $inputData1['name_of_member'] = $member->name;
                    $inputData1['date_of_death'] = $member->getRawDateOfDeath();
                    $inputData1['display_till_date'] = $member->getRawDateOfDeath();

                    if($request['image']){

                        //$fileName = str_replace(' ', '_', $request->name).'_'.time().'.'.$request['image']->extension();
                        //$request->image->storeAs('obituary', $fileName);
                        //$inputData1['photo'] = 'storage/obituary/'.$fileName;
                        $inputData1['photo'] = $inputData['image'];
                    }

                    Obituary::create($inputData1);
                }
            }

            DB::commit();
             
            return redirect()->route('admin.family.show_details',['id'=>$request['family_id']])
                            ->with('success','Family member added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function admin_family_member_show($id) : View
    {
        $familymember = FamilyMember::with('family','MaritalStatus','BloodGroup')->find($id);
        return view('user.members.details',compact('familymember'));
    }

    public function admin_family_member_edit($id) : View
    {
        $familys = Family::all();
        $relations = Relationship::all();
        $blood_groups = BloodGroup::all();
        $marital_statuses = MaritalStatus::all();
        $familymember = FamilyMember::where('id',$id)->first();
        $titles = ['Mr', 'Ms', 'Mrs', 'Fr', 'Sr', 'Dr', 'Adv', 'Engg'];
        $members = FamilyMember::select('id','name','family_id')->orderBy('name')->get();

        return view('user.members.edit',compact('familymember','familys','relations','blood_groups','marital_statuses','titles','members'));
    }

    public function admin_family_member_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $familymember = FamilyMember::find($request->id);
             $a =  $request->validate([
                'name'      => 'required',
                'family_id' => 'required',
                'gender'    => 'required',
                'dob'       => 'required',
                'relationship_id'   => 'required',
            ]);

            $inputData = $request->all();
            if($request['image']){

                //$fileName1 = str_replace(' ', '_', $request->name).'.'.$request['image']->extension();
                $fileName = str_replace(' ', '_', $request->name).'_'.$request->id.'_'.time().'.'.$request['image']->extension();

                if($request['date_of_death']){
                    $request->image->storeAs('obituary', $fileName);
                    $inputData['image'] = 'storage/obituary/'.$fileName;
                }else{

                    $request->image->storeAs('members', $fileName);
                    $inputData['image'] = 'storage/members/'.$fileName;
                }
            }

            if($request['relationship_id']==1){ 
                $prev_head = FamilyMember::where('family_id',$request['family_id'])
                                ->where('head_of_family',1)->first();
                if($prev_head){
                    if($familymember->id !== $prev_head->id){

                        $prev_head->head_of_family=0;
                        $prev_head->relationship_id=15;
                        $prev_head->save();
                    }    
                }
                $inputData['head_of_family'] = '1';
            }else{
                $inputData['head_of_family'] = '0';
            }
            
            $member_same_mail = FamilyMember::where('family_id',$request['family_id'])
                                ->where('id','!=',$request->id)
                                ->where('email',$request['email'])->first();
            if($member_same_mail){
                $inputData['email'] = null;
            }

            if($request['marr_memb_id']){
                $exist_new_marr_memb_id = FamilyMember::find($request['marr_memb_id']);
                if($exist_new_marr_memb_id){

                    $old_married_person_diff = FamilyMember::where('marr_memb_id',$request['marr_memb_id'])
                                ->where('id','!=',$request->id)->first();
                    if($old_married_person_diff){
                        $details1['remark'] = null;
                        $details1['marr_memb_id'] = null;
                        $old_married_person_diff->update($details1);

                        if($familymember['marr_memb_id'] != null){
                            $old_spouse = FamilyMember::where('id',$familymember['marr_memb_id'])->first();

                            $details['remark'] = null;
                            $details['marr_memb_id'] = null;
                            $old_spouse->update($details);
                        }

                    }
                    $updat_married_to = FamilyMember::where('id',$request['marr_memb_id'])->first();

                    $details['remark'] = 1;
                    $details['marr_memb_id'] = $familymember['id'];
                    $updat_married_to->update($details);
                }else{
                   $request['marr_memb_id']=null; 
                }
            }
            if(($request['remark'] ==null) &&($familymember->remark==1)){

                $married_person = FamilyMember::where('id',$familymember['marr_memb_id'])->first();
                if($married_person){

                    $married_person_data['remark'] = null;
                    $married_person_data['marr_memb_id'] = null;
                    $married_person->update($married_person_data);

                    $inputData['remark'] = null;
                    $inputData['marr_memb_id'] = null;
                }else{
                    $inputData['marr_memb_id'] = null;  
                }
            }
            $familymember->update($inputData);

            if($request['date_of_death']){
                $today = date('Y-m-d');
                if($request['date_of_death']== $today){ 
                    $member_obituary = Obituary::where('member_id',$familymember->id)->first();
                    if($member_obituary){

                        $member_obituary->name_of_member = $familymember->name;
                        $member_obituary->date_of_death = $familymember->getRawDateOfDeath();
                        $member_obituary->save();

                    }else{

                        $inputData1['member_id'] = $familymember->id;
                        $inputData1['name_of_member'] = $familymember->name;
                        $inputData1['date_of_death'] = $familymember->getRawDateOfDeath();
                        $inputData1['display_till_date'] = $familymember->getRawDateOfDeath();

                        if($request['image']){

                            //$fileName = str_replace(' ', '_', $request->name).'.'.$request['image']->extension();
                            //$request->image->storeAs('obituary', $fileName);
                            $inputData1['photo'] = $inputData['image'];
                        }else{
                            $inputData1['photo'] = $familymember->image;

                        }
                        
                        Obituary::create($inputData1);
                    }
                }

            }


            DB::commit();

            return redirect()->route('admin.family.member.show_details',['id'=>$familymember->id])
                            ->with('success','Family member details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function admin_family_member_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $vicar =VicarDetail::where('member_id',$request->id)->first();
            if($vicar){
                $return['status'] = 'failed';
                Session::flash('error', 'Cannot delete this member because it is associated with a family member.');
                return response()->json($return);

            }
            $obituary =Obituary::where('member_id',$request->id)->first();
            if($obituary){
                $return['status'] = 'failed';
                Session::flash('error','Cannot delete member because it is associated with a family member.');
                return response()->json($return);
            }
            $payment =PaymentDetail::where('family_head_id',$request->id)->first();
            if($payment){
                $return['status'] = 'failed';
                Session::flash('error','Cannot delete this member because member have payment details associated.');
                return response()->json($return);
            }
            $org =Organization::where('coordinator_id',$request->id)->first();
            if($org){
                $return['status'] = 'failed';
                Session::flash('error','Cannot delete member because it is associated with an organization.');
                return response()->json($return);
            }
            $org_officer =OrganizationOfficer::where('member_id',$request->id)->first();
            if($org_officer){
                $return['status'] = 'failed';
                Session::flash('error','Cannot delete member because it is associated with an organization.');
                return response()->json($return);
            }
            $prayer_group =PrayerGroup::orWhere('leader_id',$request->id)->orWhere('coordinator_id',$request->id)->first();
            if($prayer_group){
                $return['status'] = 'failed';
                Session::flash('error','Cannot delete member because it is associated with an prayer group.');
                return response()->json($return);
            }
            $family = FamilyMember::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Family member successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {
            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Family member deletion not success.');
        }
        return response()->json($return);
    }


    public function admin_member_block_unblock(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $member = FamilyMember::find($request['member_id']);
            if($member['status']==3){
                $member['status'] =1 ;
            }else{
                $member['status'] =3 ;
            }
            $member->save();
            DB::commit();
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Member deletion not success.');
        }
        return response()->json($return);
    }

    public function CheckMarriedToPersonValid(Request $request) : JsonResponse
    {
        try{
            $married_person = FamilyMember::where('marr_memb_id',$request['marr_memb_id']);
            if($request['user_id']){
                $married_person = $married_person->where('id' != $request['user_id']);
            }
            $married_person = $married_person->count();

            if($married_person == 0) {
                $return['status'] = "Valid";
            }else{
                $return['status'] = "Invalid";
            }

         }catch (Exception $e) {

            $return['status'] = $e->getMessage();
        }

        return response()->json($return);
    }

    public function admin_family_member_import() : View
    {
        return view('user.import');
    }

    public function import_progress(Request $request)
    {
        $progress = Cache::get('import_progress', 0);
        return response()->json([
            'progress' => $progress,
        ]);
    }

    public function admin_family_member_import_store(Request $request) : JsonResponse
    {
        $fileData=$request->file('excel_file');

        $family_member_import = new FamilyMemberImport();
        Excel::import($family_member_import, $fileData);
        $output = $family_member_import->getImportResult();
        return response()->json([$output]);
    }

    public function family_members_list(Request $request): JsonResponse
    {
        $searchTag = request()->get('search_tag');
        $page =  request()->get('page');
        $head_member =  request()->get('head_member');

        $familyMembersQuery = FamilyMember::query()

        ->where('status',1)
        ->where(function ($query) use ($searchTag) {
            $query->whereHas('Family', function ($subquery) use ($searchTag) {
                $subquery->where('family_name', 'like', '%' . $searchTag . '%');
            })
            ->orWhere('name', 'like', '%' . $searchTag . '%');

           
        });
        // $relationshipIds = [4,5,8,11];
        // $familyMembersQuery->whereNotIn('relationship_id',$relationshipIds);

        if($page) {
            
            $familyMembersQuery->whereNull('date_of_death');
        }
        if($head_member) {
            
            $familyMembersQuery->where('relationship_id',1);
        }
        
        $familyMembers = $familyMembersQuery->orderBy('name')->get()
        
        ->map(function ($member) {

            if($member->Family){

                $familyName = $member->Family->family_name;
            }else{
                $familyName = '';
            }

            return ['id' => $member->id, 'text' => $member->name . ' (' . $familyName . ')'];
        });

        return response()->json(['results' => $familyMembers]);
    }

    public function checkFamiyHeadUpdated(Request $request): JsonResponse
    {
        $family_id = $request['family_id'];
        $familyHead = FamilyMember::where('family_id',$family_id)->where('head_of_family',1)->count();
        return response()->json(['count' => $familyHead]);
    }

    public function admin_family_list_pending() : View
    {
        return view('approval.family.index',[]);
    }

    public function admin_family_Datatable_pending()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(Family::select('*')->where('status',2))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('prayer_group', function ($family) {
                return $family->PrayerGroup->group_name;
            })
            ->addColumn('action', 'approval.family.pending-family-datatable-action')
            ->rawColumns(['action','prayer_group'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function admin_family_show_pending($id) : View
    {
        $family = Family::where('id',$id)->with('Members','PrayerGroup','HeadOfFamily')->first();
        $prayer_groups = PrayerGroup::all();
        return view('approval.family.details',compact('family','prayer_groups'));
    }

    public function admin_family_approve(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $family = Family::find($request['family_id']);
            $family->status=1;
            $family->save();;
            DB::commit();

            return redirect()->route('admin.family.list')
                    ->with('success','Family details successfully Approved.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function admin_family_members_list_pending() : View
    {
        return view('approval.members.index');
    }

    public function admin_family_members_Datatable_pending()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(FamilyMember::select('*')->where('status',2)->with('family','relationship'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('image', function ($familyMember) {

                if ($familyMember->image) {
                    return '<img  class="img-70 rounded-circle" src="' . asset($familyMember->image) . '"  alt="Family Member Image" style="height: 70px;">';
                } else {
                    $nameWords = explode(' ', $familyMember->name);
                    $nameLetters = '';

                    foreach ($nameWords as $word) {
                        $nameLetters .= substr($word, 0, 1);
                        if(strlen($nameLetters) >= 2) {
                            break;
                        }
                    }

                    if(strlen($nameLetters) == 1) {
                        //$nameLetters = substr($this->name, 0, 2);
                        $nameLetters = $nameLetters;
                    }

                    $backgroundColors = ['#ff7f0e', '#2ca02c', '#1f77b4', '#d62728', '#9467bd'];
                    $backgroundColor = $backgroundColors[array_rand($backgroundColors)];

                    return '<div class="img-70 rounded-circle text-center" style="height: 70px; width: 70px; background-color: ' . $backgroundColor . '; color: white; line-height: 70px; font-size: 24px;">' . $nameLetters . '</div>';
                }
            })
            ->addColumn('dob', function ($familyMember) {
                return date($familyMember->Dob);
            })
            ->addColumn('family_name', function ($familyMember) {
                return $familyMember->family->family_name;
            })
            ->addColumn('relationship', function ($familyMember) {
                return $familyMember->relationship->relation_name;
            })
           
            ->addColumn('action', 'approval.members.pending-family-members-datatable-action')
            ->rawColumns(['image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }


    public function admin_family_member_show_pending($id) : View
    {
        $familymember = FamilyMember::with('family','MaritalStatus','BloodGroup')->find($id);
        return view('approval.members.details',compact('familymember'));
    }


    public function admin_family_member_approve(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $member = FamilyMember::find($request['member_id']);
            $member->status=1;
            $member->save();;
            DB::commit();
            return redirect()->route('admin.family.members.list')
                    ->with('success','Family member details successfully Approved.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function GetMemberPhoneNumber(Request $request) : JsonResponse
    {
        try{
            $member = FamilyMember::find($request['member_id']);
            
            if($member){
                if ($member->mobile !== null) {
                    $return['phone'] = $member->mobile;
                }elseif($member->alt_contact_no !== null){
                    $return['phone'] = $member->alt_contact_no;
                }else{
                    $return['phone'] = null;   
                }
            }else{

                $return['phone'] = null;   
            }
         }catch (Exception $e) {

            $return['status'] = $e->getMessage();
        }

        return response()->json($return);
    }

    public function GetFamilies(Request $request): JsonResponse
    {
        $searchTag = request()->get('search_tag');
        $prayer_group_id =  request()->get('prayer_group_id');

        $familyQuery = Family::query()

        ->where('status',1)
        ->where(function ($query) use ($searchTag) {
            $query->whereHas('headOfFamily', function ($subquery) use ($searchTag) {
                $subquery->where('name', 'like', '%' . $searchTag . '%');
            })
            ->orWhere('family_name', 'like', '%' . $searchTag . '%');
        });

        if($prayer_group_id) {
            
            $familyQuery->where('prayer_group_id',$prayer_group_id);
        }
        $family = $familyQuery->orderBy('family_name')->get()
        
        ->map(function ($family) {

            if($family->headOfFamily){

                $head = $family->headOfFamily->name;
            }else{
                $head = '';
            }
            return ['id' => $family->id, 'text' => $family->family_name . ' (' . $head . ')' ];
        });

        return response()->json(['results' => $family]);
    }

    
    public function StoreWwebDeviceId(Request $request) {
        DB::beginTransaction();
        try {
            $User = Auth::user();

            $user_devices=DeviceDetail::where('user_id',$User->id)
                        ->where('device_token',$request->device_token)->first();
            if(empty($user_devices)){
                $device_data=[
                        'user_id'        => $User->id,
                        'device_token'      => $request->device_token,
                        // 'os'             => $request->os,
                        // 'model'          => $request->model,
                        // 'app_version'    => $request->app_version,
                        'device_id'      =>"hjbhbhj",
                        'os'             => "Web",
                        'model'          => "0001",
                        'app_version'    => "2023",
                ];
                $new=new DeviceDetail;
                $validator = Validator::make($device_data,$new->rules);
                if($validator->fails())  { 
                    foreach ($validator->errors()->getMessages() as $key => $value) {
                        throw new Exception($value[0]);
                    }
                }
                $DeviceDetails=DeviceDetail::create($device_data);
            }else{
                $user_devices=$user_devices->toArray();
                DeviceDetail::where('id', $user_devices['id'])
                            ->update(array('status' => 'Active'));
            }

            DB::commit();
            $return['result'] ="success";

        }catch (Exception $e) {
            DB::rollback();
           $return['result']=$e->getMessage();
        }
        return response()->json($return);
    }
}
