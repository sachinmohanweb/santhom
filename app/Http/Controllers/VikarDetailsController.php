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

use App\Models\VikarDetail;

class VikarDetailsController extends Controller
{

    public function vikars_list() : View
    {
        return view('vikar_details.index',[]);
    }
    public function vikars_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(VikarDetail::select('*'))
             ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('action', 'vikar_details.vikar-datatable-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function vikar_create() : View
    {
        return view('vikar_details.create');
    }

    public function vikar_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'name' => 'required',
                'family_name' => 'required',
                'dob' => 'required',
                'designation' => 'required',
                'date_of_joining' => 'required',
                'email' => 'required',
            ]);
            $inputData = $request->all();
            $inputData['status'] = 1;

            if($request['image']){

                $fileName = str_replace(' ', '_', $request->name).'.'.$request['image']->extension();
                $request->image->storeAs('vikars', $fileName);
                $inputData['photo'] = 'storage/vikars/'.$fileName;
            }
            VikarDetail::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.vikar.list')
                            ->with('success','Vikar details added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function vikar_show($id) : View
    {
        $VikarDetail = VikarDetail::where('id',$id)->first();

        return view('vikar_details.details',compact('VikarDetail'));
    }

    public function vikar_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $VikarDetail = VikarDetail::find($request->id);
            $a =  $request->validate([
                'name' => 'required',
                'family_name' => 'required',
                'dob' => 'required',
                'designation' => 'required',
                'date_of_joining' => 'required',
                'email' => 'required',
            ]);

            $inputData = $request->all();
            $inputData['status'] = 1;

            if($request['image']){

                $fileName = str_replace(' ', '_', $request->name).'.'.$request['image']->extension();
                $request->image->storeAs('vikars', $fileName);
                $inputData['photo'] = 'storage/vikars/'.$fileName;
            }

            $VikarDetail->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Vikar details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function vikar_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $VikarDetail = VikarDetail::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Vikar details successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Vikar details deletion not success.');
        }
        return response()->json($return);
    }

}
