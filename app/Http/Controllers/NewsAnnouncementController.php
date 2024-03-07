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

use App\Models\NewsAnnouncement;

class NewsAnnouncementController extends Controller
{

    public function news_announcement_list() : View
    {
        return view('news_announcement.index',[]);
    }
    public function news_announcemnt_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(NewsAnnouncement::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('created', function ($news) {
                return \Carbon\Carbon::parse($news['created_at'])->format('d-m-Y');
            })
            ->addColumn('action', 'news_announcement.news-announcement-datatable-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function news_announcement_create() : View
    {
        $news = NewsAnnouncement::all();
        return view('news_announcement.create',compact('news'));
    }

    public function news_announcement_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'heading' => 'required',
                'body' => 'required',
            ]);

            $inputData = $request->all();

            if($request['image']){

                $fileName = str_replace(' ', '_', $request->heading).'.'.$request['image']->extension();
                $request->image->storeAs('news', $fileName);
                $inputData['image'] = 'storage/news/'.$fileName;
            }
            NewsAnnouncement::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.news_announcement.list')
                            ->with('success','NEw/announcement added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function news_announcement_show($id) : View
    {
        $news = NewsAnnouncement::where('id',$id)->first();

        return view('news_announcement.details',compact('news'));
    }

    public function news_announcement_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $news = NewsAnnouncement::find($request->id);
            $a =  $request->validate([
                'heading' => 'required',
                'body' => 'required',
            ]);

            $inputData = $request->all();

            if($request['image']){

                $fileName = str_replace(' ', '_', $request->heading).'.'.$request['image']->extension();

                $request->image->storeAs('news', $fileName);
                $inputData['image'] = 'storage/news/'.$fileName;
            }
            $news->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','News/announcement  details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function news_announcement_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $event = NewsAnnouncement::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'NEw/announcement/Announcement successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Event deletion not success.');
        }
        return response()->json($return);
    }

}
