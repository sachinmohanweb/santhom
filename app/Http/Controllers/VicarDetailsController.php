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

use App\Models\VicarDetail;

class VicarDetailsController extends Controller
{

    public function vicars_list() : View
    {
        return view('vicar_details.index',[]);
    }
    public function vicars_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(VicarDetail::select('*'))
             ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('image', function ($vicar) {

                if ($vicar->photo) {
                    return '<img  class="img-70 rounded-circle" src="' . asset($vicar->photo) . '"  alt="Family Member Image" style="height: 70px;">';
                } else {
                    $nameWords = explode(' ', $vicar->name);
                    $nameLetters = '';

                    foreach ($nameWords as $word) {
                        $nameLetters .= substr($word, 0, 1);
                        if(strlen($nameLetters) >= 2) {
                            break;
                        }
                    }

                    if(strlen($nameLetters) == 1) {
                        $nameLetters = substr($vicar->name, 0, 2);
                    }

                    $backgroundColors = ['#ff7f0e', '#2ca02c', '#1f77b4', '#d62728', '#9467bd'];
                    $backgroundColor = $backgroundColors[array_rand($backgroundColors)];

                    return '<div class="img-70 rounded-circle text-center" style="height: 70px; width: 70px; background-color: ' . $backgroundColor . '; color: white; line-height: 70px; font-size: 24px;">' . $nameLetters . '</div>';
                }
            })
            ->addColumn('action', 'vicar_details.vicar-datatable-action')
            ->rawColumns(['image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function vicar_create() : View
    {
        return view('vicar_details.create');
    }

    public function vicar_store(Request $request): RedirectResponse
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
                $request->image->storeAs('vicars', $fileName);
                $inputData['photo'] = 'storage/vicars/'.$fileName;
            }
            VicarDetail::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.vicar.list')
                            ->with('success','Vicar details added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function vicar_show($id) : View
    {
        $VicarDetail = VicarDetail::where('id',$id)->first();

        return view('vicar_details.details',compact('VicarDetail'));
    }

    public function vicar_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $VicarDetail = VicarDetail::find($request->id);
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
                $request->image->storeAs('vicars', $fileName);
                $inputData['photo'] = 'storage/vicars/'.$fileName;
            }

            $VicarDetail->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Vicar details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function vicar_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $VicarDetail = VicarDetail::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Vicar details successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Vicar details deletion not success.');
        }
        return response()->json($return);
    }

}
