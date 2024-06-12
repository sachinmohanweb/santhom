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
            ->of(DailySchedules::select('*')->where('status',1)
            //->orderByRaw("CASE WHEN date >= CURDATE() THEN 0 ELSE 1 END, date ASC")
                ->where('date', '>=', \Carbon\Carbon::today())
                ->orderBy('date', 'asc')
            )
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

            $a =  $request->validate([
                    'date' => 'required',
                    'details' => 'required',
            ]);

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

            $a =  $request->validate([
                    'date' => 'required',
                    'details' => 'required',
            ]);

            $requestData = $request->all();

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
