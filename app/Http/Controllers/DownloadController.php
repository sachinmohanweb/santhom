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

use App\Models\Download;

class DownloadController extends Controller
{

    public function download_list() : View
    {
        return view('downloads.index',[]);
    }

    public function download_datatable()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(Download::select('id','title','type','file','details'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('file', function ($download) {

                if($download->type == 'jpg' || $download->type == 'jpeg' || $download->type == 'png' || $download->type == 'gif') {
                    return '<a href="' . asset($download->file) . '" target="_blank"><img  class="img-70 rounded-circle" src="' . asset($download->file) . '"  alt="file" style="height: 70px;"></a>';
                }else {
                    
                    $nameLetters = $download->type;
                    $backgroundColors = ['#ff7f0e', '#2ca02c', '#1f77b4', '#d62728', '#9467bd'];
                    $backgroundColor = $backgroundColors[array_rand($backgroundColors)];

                    return '<a href="' . asset($download->file) . '" target="_blank"><div class="img-70 rounded-circle text-center" style="height: 70px; width: 70px; background-color: ' . $backgroundColor . '; color: white; line-height: 70px; font-size: 24px;">' . $nameLetters . '</div></a>';
                }
            })
            ->addColumn('action', 'downloads.downloads-datatable-action')
            ->rawColumns(['file','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function download_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {

            $a =  $request->validate([
                'title'            => 'required',
                'file'            => 'required',
            ]);

            $inputData = $request->all();

            $fileName = str_replace(' ', '_', $request->title).'.'.$request['file']->extension();
            $request->file->storeAs('downloads', $fileName);

            $inputData['file'] = 'storage/downloads/'.$fileName;
            $inputData['type'] = $request['file']->extension();


            Download::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.download.list')
                            ->with('success','File added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function download_get(Request $request) : JsonResponse
    {
        $download = Download::find($request['id']);
        return response()->json($download);
    }

    public function download_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $download = Download::find($request->id);

             $a =  $request->validate([
                'title'            => 'required',
            ]);

            $inputData = $request->all();
            if($request['file']){
                $fileName = str_replace(' ', '_', $request->title).'.'.$request['file']->extension();
                $request->file->storeAs('downloads', $fileName);

                $inputData['file'] = 'storage/downloads/'.$fileName;
                $inputData['type'] = $request['file']->extension();
            }
            $download->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','File successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function download_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $download = Download::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'File successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'File deletion not success.');
        }
        return response()->json($return);
    }

}
