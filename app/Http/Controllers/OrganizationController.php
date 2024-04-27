<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use DB;
use Excel;
use Cache;
use Session;
use Exception;
use Datatables;

use App\Models\Organization;
use App\Models\PrayerGroup;
use App\Models\Notification;
use App\Models\FamilyMember;
use App\Models\NewsAnnouncement;
use App\Models\OrganizationOfficer;

class OrganizationController extends Controller
{

    public function organizations_list() : View
    {
        return view('organizations.index',[]);
    }

    public function organizations_datatable()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(Organization::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('action', 'organizations.organizations-datatable-action')
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function organizations_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'organization_name'            => 'required',
            ]);

            $inputData = $request->all();
            $inputData['status'] = 1;

            Organization::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.organizations.list')
                            ->with('success','Organization added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }
    
    public function Organization_show($id) : View
    {
        $organization = Organization::where('id',$id)->first();
        return view('organizations.details',compact('organization'));
    }

    public function organizations_get(Request $request) : JsonResponse
    {
        $organization = Organization::find($request['id']);
        return response()->json($organization);
    }

    public function organizations_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $group = Organization::find($request->id);
             $a =  $request->validate([
                'organization_name'            => 'required',
            ]);

            $inputData = $request->all();
            $inputData['status'] = 1;

            $group->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Organization details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function organizations_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $notification =Notification::where('type',4)->where('group_org_id',$request->id)->first();
            if($notification){
                $return['status'] = 'failed';
                Session::flash('error','Cannot delete this Organization because it is associated with a notification.');
                return response()->json($return);
            }
            $news =NewsAnnouncement::where('type',4)->where('group_org_id',$request->id)->first();
            if($news){
                $return['status'] = 'failed';
                Session::flash('error','Cannot delete this Organization because it is associated with a news announcement.');
                return response()->json($return);
            }

            $group = Organization::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Organization successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Organization deletion not success.');
        }
        return response()->json($return);
    }

    public function getGroupOrgList(Request $request): JsonResponse
    {
        $searchTag = request()->get('search_tag');
        $type =  request()->get('type');


        if ($type == 3) {

            $group = PrayerGroup::select('*')->where('status', 1);

            if($searchTag) {
                $group->Where('group_name', 'like', '%' . $searchTag . '%');
            }

            $group = $group->orderBy('group_name')->get();

            $results = $group->map(function ($group) {
                return ['id' => $group->id, 'text' => $group->group_name];
            });

        }else{

            $org = Organization::select('*')->where('status', 1);
            if($searchTag) {
                $org->Where('organization_name', 'like', '%' . $searchTag . '%');
            }

            $org = $org->orderBy('organization_name')->get();

            $results = $org->map(function ($org) {
                return ['id' => $org->id, 'text' => $org->organization_name];
            });
        
        }

        return response()->json(['results' => $results]);

    }

    public function store_organization_officers(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'organization_id'            => 'required',
                'member_id'            => 'required',
                'position'            => 'required',
            ]);

            $inputData = $request->all();

            if($request['member_id']){

                $member= FamilyMember::find($request['member_id']);
                $inputData['member_name'] = $member['name'];
            }

            OrganizationOfficer::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.organizations.show_details',[$request['organization_id']])
                            ->with('success','Organization officer added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }
    }

    public function organization_officer_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $member = OrganizationOfficer::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Successfully deleted officer details.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Officer deletion not success.');
        }
        return response()->json($return);
    }

}
