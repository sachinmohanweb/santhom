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

use App\Models\PrayerGroup;

class PrayerGroupController extends Controller
{

    public function prayer_group_list() : View
    {
        return view('prayer_groups.index',[]);
    }

    public function prayer_group_datatable()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(PrayerGroup::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('action', 'prayer_groups.prayer-group-datatable-action')
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function prayer_group_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'group_name'            => 'required',
                'leader'                => 'required',
                'leader_phone_number'   => 'required',
            ]);

            $inputData = $request->all();
            $inputData['status'] = 1;

            PrayerGroup::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.prayergroup.list')
                            ->with('success','Prayer Group added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function prayer_group_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $group = PrayerGroup::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Prayer Group successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Prayer Group deletion not success.');
        }
        return response()->json($return);
    }



    public function prayer_group_get(Request $request) : JsonResponse
    {
        $group = PrayerGroup::find($request['id']);
        return response()->json($group);
    }

    public function prayer_group_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $group = PrayerGroup::find($request->id);
            
            $a =  $request->validate([
                'group_name'            => 'required',
                'leader'                => 'required',
                'leader_phone_number'   => 'required',
            ]);

            $inputData = $request->all();
            $inputData['status'] = 1;

            $group->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Prayer Group  details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

}
