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

use App\Models\Event;
use App\Models\FamilyMember;

use App\Notifications\NotificationPusher; 

class EventController extends Controller
{

    public function event_list() : View
    {
        return view('events.index',[]);
    }
    public function event_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(Event::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('date', function ($verse) {
                return date("d/m/Y", strtotime($verse->date));
            })
            ->addColumn('time', function ($event) {
                 return $event->time;
            })
            ->addColumn('action', 'events.event-datatable-action')
            ->rawColumns(['action','prayer_group'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function event_create() : View
    {
        $events = Event::all();
        return view('events.create',compact('events'));
    }

    public function event_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'event_name' => 'required',
                'date' => 'required',
                'time_value' => 'required',
            ]);

            $inputData = $request->all();

            if($request['image']){

                //$fileName = str_replace(' ', '_', $request->event_name).'.'.$request['image']->extension();
                $fileName = 'events_first'.time().'.'.$request['image']->extension();

                $request->image->storeAs('events', $fileName);
                $inputData['image'] = 'storage/events/'.$fileName;
            }
            if($request['image2']){

                //$fileName = str_replace(' ', '_', $request->event_name).'.'.$request['image']->extension();
                $fileName2 = 'events_second'.time().'.'.$request['image2']->extension();

                $request->image2->storeAs('events', $fileName2);
                $inputData['image2'] = 'storage/events/'.$fileName2;
            }

            $event = Event::create($inputData);
            DB::commit();

            if($event->image !== null) {
                $event->image = asset('/') . $event->image;
            }
            if($event->image2 !== null) {
                $event->image2 = asset('/') . $event->image2;
            }

            $push_data = [];
            $push_data['devicesIds']    =  FamilyMember::whereNotNull('refresh_token')->pluck('refresh_token')->toArray();
            $push_data['title']         =   $event->event_name;
            $push_data['body']          =   'on '.$event->date .' at '. $event->time;

            $push_data['route']         =   'events';
            $push_data['id']            =   $event['id'];
            $push_data['category']      =   'Events';

            $push_data['data1']         =   $event->event_name;
            $push_data['data2']         =   'Date : '.$event->date;
            $push_data['data3']         =   'Time : '.$event->time;
            $push_data['data4']         =   $event->venue;
            $push_data['data5']         =   $event->details;
            $push_data['data6']         =   $event->link;
            $push_data['image1']        =   $event->image;
            $push_data['image2']        =   $event->image2;

            $pusher = new NotificationPusher();
            $pusher->push($push_data);

            return redirect()->route('admin.event.list')
                            ->with('success','Event added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function event_show($id) : View
    {
        $event = Event::where('id',$id)->first();

        return view('events.details',compact('event'));
    }

    public function event_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $event = Event::find($request->id);
             $a =  $request->validate([
                'event_name' => 'required',
                'date' => 'required',
                'time_value' => 'required',
            ]);

            $inputData = $request->all();

            if($request['image']){

                //$fileName = str_replace(' ', '_', $request->event_name).'.'.$request['image']->extension();
                $fileName = 'events_first'.time().'_'.$request->id.'.'.$request['image']->extension();
                $request->image->storeAs('events', $fileName);
                $inputData['image'] = 'storage/events/'.$fileName;
            }

            if($request['image2']){

                //$fileName = str_replace(' ', '_', $request->event_name).'.'.$request['image']->extension();
                $fileName2 = 'events_second'.time().'.'.$request['image2']->extension();

                $request->image2->storeAs('events', $fileName2);
                $inputData['image2'] = 'storage/events/'.$fileName2;
            }

            $event->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Event details successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function event_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $event = Event::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Event successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Event deletion not success.');
        }
        return response()->json($return);
    }

}
