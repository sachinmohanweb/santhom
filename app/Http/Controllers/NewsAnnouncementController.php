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

use App\Models\FamilyMember;
use App\Models\NewsAnnouncement;

use App\Notifications\NotificationPusher; 

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
            
            if(in_array($request->type, [3,4])){
                $a =  $request->validate([
                    'heading' => 'required',
                    'body' => 'required',
                    'type' => 'required',
                    'group_org_id' => 'required',
                ]);  
            }else{
                 $a =  $request->validate([
                    'heading' => 'required',
                    'body' => 'required',
                    'type' => 'required',
                ]);  
            }

            $inputData = $request->all();

            if($request->type==1){
                $type_name = 'Trustee';
            }elseif($request->type==2){
                $type_name = 'Secretary';
            }elseif($request->type==3){
                $type_name = 'Prayer Group';
            }else{
                $type_name = 'Organization';
            }

            $inputData['type_name'] = $type_name;

            if($request['image']){

                //$fileName = str_replace(' ', '_', $request->heading).'.'.$request['image']->extension();
                $fileName = 'news_first'.time().'.'.$request['image']->extension();

                $request->image->storeAs('news', $fileName);
                $inputData['image'] = 'storage/news/'.$fileName;
            }
            if($request['image2']){

                //$fileName = str_replace(' ', '_', $request->heading).'.'.$request['image']->extension();
                $fileName2 = 'news_second'.time().'.'.$request['image2']->extension();

                $request->image2->storeAs('news', $fileName2);
                $inputData['image2'] = 'storage/news/'.$fileName2;
            }
            $news = NewsAnnouncement::create($inputData);
            DB::commit();

            if($news->image !== null) {
                $news->image = asset('/') . $news->image;
            }

            $push_data = [];
            $push_data['devicesIds']    =  FamilyMember::whereNotNull('refresh_token')->pluck('refresh_token')->toArray();
            $push_data['title']         =   $news->heading;
            $push_data['body']          =   $news->body;

            $push_data['route']         =   'news_announcements';
            $push_data['id']            =   $news['id'];
            $push_data['data1']         =   $news->heading;
            $push_data['data2']         =   $news->body;
            $push_data['data3']         =   $news->type_name;
            $push_data['data4']         =   $news->group_organization_name;
            $push_data['data5']         =   $news->link;
            $push_data['data6']         =   null;
            $push_data['image']         =   $news['image'];

            $pusher = new NotificationPusher();
            $pusher->push($push_data);

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

        $type = [ 1 => 'Trustee',2 => 'Secretary',3 => 'Prayer Group',4 => 'Organization'];

        return view('news_announcement.details',compact('news','type'));
    }

    public function news_announcement_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $news = NewsAnnouncement::find($request->id);
            $a =  $request->validate([
                'heading' => 'required',
                'body' => 'required',
                'type' => 'required',
            ]);

            $inputData = $request->all();

            if(($request['type']==1) || ($request['type']==2)){

                $inputData['group_org_id'] =Null;
            }
            
            if($request->type==1){
                $type_name = 'Trustee';
            }elseif($request->type==2){
                $type_name = 'Secretary';
            }elseif($request->type==3){
                $type_name = 'Prayer Group';
            }else{
                $type_name = 'Organization';
            }

            $inputData['type_name'] = $type_name;

            if($request['image']){

                //$fileName = str_replace(' ', '_', $request->heading).'.'.$request['image']->extension();
                $fileName = 'news_first'.time().'_'.$request->id.'.'.$request['image']->extension();


                $request->image->storeAs('news', $fileName);
                $inputData['image'] = 'storage/news/'.$fileName;
            }
            if($request['image2']){

                //$fileName = str_replace(' ', '_', $request->heading).'.'.$request['image']->extension();
                $fileName2 = 'news_second'.time().'.'.$request['image2']->extension();

                $request->image2->storeAs('news', $fileName2);
                $inputData['image2'] = 'storage/news/'.$fileName2;
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
