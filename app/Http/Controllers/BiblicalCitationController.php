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

use App\Models\BiblicalCitation;
use App\Imports\BibleCitationsImport;

class BiblicalCitationController extends Controller
{

    public function admin_biblical_citation_list() : View
    {
        return view('biblicalcitation.index',[]);
    }
    public function admin_bible_citation_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(BiblicalCitation::select('*')->where('status',1))
            ->addColumn('action', 'biblicalcitation.biblical-citation-datatable-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function admin_biblical_citation_create() : View
    {
        return view('biblicalcitation.create');
    }

    public function admin_biblical_citation_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'date' => 'required',
                'reference' => 'required',
            ]);

            $BiblicalCitation = BiblicalCitation::create($request->all());
            DB::commit();
             
            return redirect()->route('admin.biblical.citation.list')
                            ->with('success',"Success! Biblical Citation has been successfully added");
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function admin_biblical_citation_show($id) : View
    {
        $BiblicalCitation = BiblicalCitation::where('id',$id)->first();
        return view('biblicalcitation.details',compact('BiblicalCitation'));
    }

    public function admin_biblical_citation_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $BiblicalCitation = BiblicalCitation::find($request->id);
            $a =  $request->validate([
                'date' => 'required',
                'reference' => 'required',
            ]);
            $BiblicalCitation->update($request->all());
            DB::commit();

            return redirect()->back()
                    ->with('success','Biblical Citation successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function admin_biblical_citation_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $BiblicalCitation = BiblicalCitation::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Biblical Citation successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Biblical Citation deletion not success.');
        }
        return response()->json($return);
    }

    public function admin_biblical_citation_import() : View
    {
        return view('biblicalcitation.import');
    }

    public function import_progress_biblical_citation(Request $request)
    {
        $progress = Cache::get('import_progress_bible_citations', 0);
        return response()->json([
            'progress' => $progress,
        ]);
    }

    public function admin_biblical_citation_import_store(Request $request) : JsonResponse
    {
        $fileData=$request->file('excel_file');

        $bible_citations_import = new BibleCitationsImport();
        Excel::import($bible_citations_import, $fileData);
        $output = $bible_citations_import->getImportResult();
        return response()->json([$output]);
    }
}
