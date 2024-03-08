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

use App\Models\Obituary;

class ObituaryController extends Controller
{

    public function obituary_list() : View
    {
        return view('obituary.index',[]);
    }
    public function obituary_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(Obituary::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('created', function ($news) {
                return \Carbon\Carbon::parse($news['created_at'])->format('d-m-Y');
            })
            ->addColumn('action', 'obituary.obituary-datatable-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function obituary_create() : View
    {
        $obituary = Obituary::all();
        return view('obituary.create',compact('obituary'));
    }

    public function obituary_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {

            $a =  $request->validate([
                'name_of_member' => 'required',
                'date_of_death' => 'required',
                'display_till_date' => 'required',
            ]);

            $inputData = $request->all();

            if($request['photo']){

                $fileName = str_replace(' ', '_', $request->name_of_member).'.'.$request['photo']->extension();
                $request->photo->storeAs('obituary', $fileName);
                $inputData['photo'] = 'storage/obituary/'.$fileName;
            }
            Obituary::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.obituary.list')
                            ->with('success','Obituary details added.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function obituary_show($id) : View
    {
        $obituary = Obituary::where('id',$id)->first();

        return view('Obituary.details',compact('obituary'));
    }

    public function obituary_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $obituary = Obituary::find($request->id);
            $a =  $request->validate([
                'name_of_member' => 'required',
                'date_of_death' => 'required',
                'display_till_date' => 'required',
            ]);

            $inputData = $request->all();

            if($request['photo']){

                $fileName = str_replace(' ', '_', $request->name_of_member).'.'.$request['photo']->extension();
                $request->photo->storeAs('obituary', $fileName);
                $inputData['photo'] = 'storage/obituary/'.$fileName;
            }
            $obituary->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Obituary details updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function obituary_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $obituary = Obituary::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Obituary deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Obituary deletion not success.');
        }
        return response()->json($return);
    }

}
