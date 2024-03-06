<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use DB;
use Session;

use App\Models\VikarMessage;

class VikarMessageController extends Controller
{

    public function vikar_message_list(): View
    {
        return view('vikar_messages.index',[]);
    }

    public function vikar_message_create() : View
    {
        return view('vikar_messages.create',[]);
    }

    public function vikar_message_store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'subject' => 'required',
                'message_body' => 'required',
                'image' => 'required',
            ]);
            $inputData = $request->all();
            $inputData['status'] = 1;
            if($request['image']){

                $fileName = str_replace(' ', '_', $request->subject).'.'.$request['image']->extension();
                $request->image->storeAs('vikar_messages', $fileName);
                $inputData['image'] = 'storage/vikar_messages/'.$fileName;
            }
            VikarMessage::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.vikarmessages.list')
                            ->with('success','Vikar Message added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }
    }

    public function vikars_message_Datatable()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(VikarMessage::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('image', function ($vikarmessage) {
                return '<img  class="img-70 rounded-circle" src="' . asset($vikarmessage->image) . '"  alt="Family Member Image" style="height: 70px;">';
            })           
            ->addColumn('action', 'vikar_messages.vikar-messages-datatable-action')
            ->rawColumns(['image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function vikar_message_show($id) : View
    {
        $message = VikarMessage::find($id);
        return view('vikar_messages.details',compact('message'));
    }

    public function vikar_message_edit($id) : View
    {
        $message = VikarMessage::find($id);
        return view('vikar_messages.edit',compact('message'));
    }

    public function vikar_message_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {

            $message = VikarMessage::find($request->id);

            $a =  $request->validate([
                'subject' => 'required',
                'message_body' => 'required',
            ]);
            $inputData = $request->all();
            $inputData['status'] = 1;
            if($request['image']){

                $fileName = str_replace(' ', '_', $request->subject).'.'.$request['image']->extension();
                $request->image->storeAs('vikar_messages', $fileName);
                $inputData['image'] = 'storage/vikar_messages/'.$fileName;
            }
            $message->update($inputData);
            DB::commit();
             
            return redirect()->route('admin.vikarmessages.list')
                            ->with('success','Vikar Message updated successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }
    }

    public function vikar_message_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $message = VikarMessage::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Vikar message successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Message deletion not success.');
        }
        return response()->json($return);
    }
}
