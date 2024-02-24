<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

use DB;
use Session;
use Exception;
use Datatables;

use App\Models\Family;
use App\Models\BloodGroup;
use App\Models\PrayerGroup;
use App\Models\FamilyMember;
use App\Models\Relationship;
use App\Models\MaritalStatus;

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
            ->of(Family::select('*'))
            ->addColumn('action', 'user.family.family-datatable-action')
            ->rawColumns(['action'])
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
                'family_code' => 'required',
                'family_name' => 'required',
                'family_email' => 'required',
                'head_of_family' => 'required',
                'prayer_group' => 'required',
                'address1' => 'required',
                'address2' => 'required',
                'pincode' => 'required',
            ]);
            Family::create($request->all());
            DB::commit();
             
            return redirect()->route('admin.family.list')
                            ->with('success','Family added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function admin_family_show($id) : View
    {
        $family = Family::where('id',$id)->first();
        return view('user.family.details',compact('family'));
    }

    public function admin_family_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $family = Family::find($request->id);
            $a =  $request->validate([
                'family_code' => 'required',
                'family_name' => 'required',
                'family_email' => 'required',
                'head_of_family' => 'required',
                'prayer_group' => 'required',
                'address1' => 'required',
                'address2' => 'required',
                'pincode' => 'required',
            ]);
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
            $family = Family::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Family successfully deleted.');
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
            ->of(FamilyMember::select('*')->with('family','relationship'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('image', function ($familyMember) {
                return '<img  class="img-70 rounded-circle" src="' . asset($familyMember->image) . '"  alt="Family Member Image" style="height: 70px;">';
            })
            ->addColumn('dob', function ($familyMember) {
                return date("d-m-Y", strtotime($familyMember->dob));
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

    public function admin_family_member_create() : View
    {   
        $familys = Family::all();
        $relations = Relationship::all();
        $blood_groups = BloodGroup::all();
        $marital_statuses = MaritalStatus::all();

        return view('user.members.create',compact('familys','blood_groups','marital_statuses','relations'));
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
                'marital_status_id' => 'required',
                'relationship_id'   => 'required',
            ]);

            $inputData = $request->all();
            $inputData['status'] = 2;

            if($request['image']){

                $fileName = $request->name.'.'.$request['image']->extension();
                $request->image->storeAs('members', $fileName);
                $inputData['image'] = 'storage/members/'.$fileName;
            }

            FamilyMember::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.family.members.list')
                            ->with('success','Family member added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function admin_family_member_show($id) : View
    {
        $familymember = FamilyMember::where('id',$id)->first();
        return view('user.members.details',compact('familymember'));
    }

    public function admin_family_member_edit($id) : View
    {
        $familymember = FamilyMember::where('id',$id)->first();
        $familys = Family::all();
        $relations = Relationship::all();
        $blood_groups = BloodGroup::all();
        $marital_statuses = MaritalStatus::all();

        return view('user.members.edit',compact('familymember','familys','relations','blood_groups','marital_statuses'));
    }

    public function admin_family_member_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
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










    public function admin_family_member_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $family = Family::find($request->id);
            $a =  $request->validate([
                'family_code' => 'required',
                'family_name' => 'required',
                'family_email' => 'required',
                'head_of_family' => 'required',
                'prayer_group' => 'required',
                'address1' => 'required',
                'address2' => 'required',
                'pincode' => 'required',
            ]);
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


}
