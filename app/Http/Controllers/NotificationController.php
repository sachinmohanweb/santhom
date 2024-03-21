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

use App\Models\Notification;

class NotificationController extends Controller
{

    public function notification_list() : View
    {
        return view('notification.index',[]);
    }
    public function notification_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(Notification::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('action', 'notification.notification-datatable-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function notification_create() : View
    {
        $Notification = Notification::all();
        return view('notification.create',compact('Notification'));
    }

    public function notification_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {

            if(in_array($request->type, [3,4])){

                $a =  $request->validate([
                    'title' => 'required',
                    'content' => 'required',
                    'group_org_id' => 'required',
                ]);
                
            }else{
                $a =  $request->validate([
                    'title' => 'required',
                    'content' => 'required',
                ]);
            }

            $inputData = $request->all();

            Notification::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.notification.list')
                            ->with('success','Notification succefully added.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function notification_show($id) : View
    {
        $Notification = Notification::where('id',$id)->first();
        $type = [ 1 => 'Trustee',2 => 'Secretary',3 => 'Prayer Group',4 => 'Organization'];

        return view('notification.details',compact('Notification','type'));
    }

    public function notification_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $notification = Notification::find($request->id);
            $a =  $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);

            $inputData = $request->all();

            if(($request['type']==1) || ($request['type']==2)){

                $inputData['group_org_id'] =Null;
            }
           
            $notification->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Notification details updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function notification_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $notification = Notification::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Notification deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Notification deletion not success.');
        }
        return response()->json($return);
    }

}
