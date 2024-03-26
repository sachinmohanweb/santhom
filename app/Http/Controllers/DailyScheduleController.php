<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use DB;
use Session;
use Exception;
use Datatables;

use App\Models\DailySchedules;

class DailyScheduleController extends Controller
{

    public function admin_daily_schedules_list() : View
    {
        return view('daily_schedule.index',[]);
    }
    public function admin_daily_schedules_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(DailySchedules::select('*')->where('status',1))
            ->addColumn('type', function($row) {
                if ($row->type == 'Normal Day') {
                    if ($row->day_category == 'Mon-Sat') {
                        return 'Default Monday to Saturday';
                    } else {
                        return 'Default Sunday';
                    }
                } else {
                    return  'Special Day ' . $row->date;
                }
            })
            // ->addColumn('details', function($row) {
            //         return $row->details;
            // })
            ->addColumn('details', function($row) {
                    $details = strip_tags($row->details);
                    $extractedContent = mb_substr($row->details, 0, 200, 'UTF-8').'......';
                    return $extractedContent;       
            })
            ->addColumn('action', 'daily_schedule.daily-schedule-datatable-action')
            ->rawColumns(['details','action'])
            ->addIndexColumn()
            
        ->make(true);
        }
        return view('index');
    }

    public function admin_daily_schedules_create() : View
    {

        return view('daily_schedule.create');
    }

    public function admin_daily_schedules_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {

            if(($request->type==1) && ($request->day_category==1)){

                $existingRecord1 = DailySchedules::where('type',1)->where('day_category',1)->first();
                if($existingRecord1){
                    $message1 = "Already added Default Monday to Saturday activities";
                    return back()->withInput()->withErrors(['message' =>  $message1]);
                }
            }
            if(($request->type==1) && ($request->day_category==2)){

                $existingRecord2 = DailySchedules::where('type',1)->where('day_category',2)->first();
                if($existingRecord2){
                    $message2 = "Already added Default SundaY activities";
                    return back()->withInput()->withErrors(['message' =>  $message2]);
                }
            }

            if($request->type==1){
                $a =  $request->validate([
                    'type' => 'required',
                    'day_category' => 'required',
                    'details' => 'required',
                ]);
            }else{

                 $a =  $request->validate([
                    'type' => 'required',
                    'date' => 'required',
                    'details' => 'required',
                ]);
            }

            $DailySchedules = DailySchedules::create($request->all());
            DB::commit();
             
            return redirect()->route('admin.daily.schedules.list')
                            ->with('success',"Success! Daily schedule has been successfully added");
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function admin_daily_schedules_show($id) : View
    {
        $DailySchedules = DailySchedules::where('id',$id)->first();

        return view('daily_schedule.details',compact('DailySchedules'));
    }

    public function admin_daily_schedules_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $DailySchedules = DailySchedules::find($request->id);
            if($request->type =='Normal Day'){
                $columnsToExclude = ['type', 'day_category'];
                $requestData = $request->except($columnsToExclude);

                $a =  $request->validate([
                    'details' => 'required',
                ]);
            }else{
                
                $requestData = $request->except('type');

                 $a =  $request->validate([
                    'date' => 'required',
                    'details' => 'required',
                ]);
            }
            $DailySchedules->update($requestData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Daily schedules successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function admin_daily_schedules_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $DailySchedules = DailySchedules::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Daily schedules successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Daily schedules deletion not success.');
        }
        return response()->json($return);
    }
}
