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

use App\Models\BibleVerse;
use App\Imports\BibleVerseImport;


class BibleVerseController extends Controller
{

    public function bible_verse_list() : View
    {
        return view('bible_verse.index',[]);
    }

    public function bible_verse_datatable()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(BibleVerse::select('*')->where('date', '>', now()->subDay()->format('Y-m-d'))->orderBy('date'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('action', 'bible_verse.bible_verse-datatable-action')
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function bible_verse_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'date'            => 'required',
                'verse'            => 'required',
                'ref'                => 'required',
            ]);

            $existingVerse = BibleVerse::where('date', $request['date'])->first();
            if ($existingVerse) {
                return redirect()->route('admin.bibleverse.list')->with('error','Bible verse already updated for this date.');
            }
            $inputData = $request->all();
            $inputData['status'] = 1;

            BibleVerse::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.bibleverse.list')
                            ->with('success','Bible verse added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function bible_verse_get(Request $request) : JsonResponse
    {
        $verse = BibleVerse::find($request['id']);
        return response()->json($verse);
    }

    public function bible_verse_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $bibleVerse = BibleVerse::find($request->id);
             $a =  $request->validate([
                'date'            => 'required',
                'verse'            => 'required',
                'ref'                => 'required',
            ]);

            $existingVerse = BibleVerse::where('date', $request['date'])
                                ->where('id','!=',$request->id)->first();
            if ($existingVerse) {
                return redirect()->route('admin.bibleverse.list')->with('error','Bible verse already updated for this date.');
            }

            $inputData = $request->all();
            $inputData['status'] = 1;

            $bibleVerse->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Bible Verse details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function bible_verse_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $verse = BibleVerse::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Bible verse successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Bible verse deletion not success.');
        }
        return response()->json($return);
    }

    public function admin_bible_verse_import() : View
    {
        return view('bible_verse.import');
    }

    public function import_progress_bible_verse(Request $request)
    {
        $progress = Cache::get('import_progress_bible', 0);
        return response()->json([
            'progress' => $progress,
        ]);
    }

    public function admin_bible_verse_import_store(Request $request) : JsonResponse
    {
        $fileData=$request->file('excel_file');

        $bible_verse_import = new BibleVerseImport();
        Excel::import($bible_verse_import, $fileData);
        $output = $bible_verse_import->getImportResult();
        return response()->json([$output]);
    }

}
