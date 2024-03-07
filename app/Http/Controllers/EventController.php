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
            ]);
            Event::create($request->all());
            DB::commit();
             
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
            ]);
            $event->update($request->all());
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
