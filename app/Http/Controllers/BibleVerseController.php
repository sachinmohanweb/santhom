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
            ->of(BibleVerse::select('*'))
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
                'verse'            => 'required',
                'ref'                => 'required',
            ]);

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
                'verse'            => 'required',
                'ref'                => 'required',
            ]);

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

}
