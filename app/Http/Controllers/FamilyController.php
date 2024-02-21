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

class FamilyController extends Controller
{

    public function admin_family_list() : View
    {
        return view('user.family.index',[]);
    }
    public function family_Datatable()
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
        return view('user.family.create',[]);
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
    
}
