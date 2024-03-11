<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use DB;
use Session;

use App\Models\VicarMessage;

class VicarMessageController extends Controller
{

    public function vicar_message_list(): View
    {
        return view('vicar_messages.index',[]);
    }

    public function vicar_message_create() : View
    {
        return view('vicar_messages.create',[]);
    }

    public function vicar_message_store(Request $request): RedirectResponse
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
                $request->image->storeAs('vicar_messages', $fileName);
                $inputData['image'] = 'storage/vicar_messages/'.$fileName;
            }
            VicarMessage::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.vicarmessages.list')
                            ->with('success','Vicar Message added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }
    }

    public function vicars_message_Datatable()
    {
        if(request()->ajax()) {

            return datatables()
            ->of(VicarMessage::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('image', function ($vicarmessage) {
                return '<img  class="img-70 rounded-circle" src="' . asset($vicarmessage->image) . '"  alt="Family Member Image" style="height: 70px;">';
            })           
            ->addColumn('action', 'vicar_messages.vicar-messages-datatable-action')
            ->rawColumns(['image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function vicar_message_show($id) : View
    {
        $message = VicarMessage::find($id);
        return view('vicar_messages.details',compact('message'));
    }

    public function vicar_message_edit($id) : View
    {
        $message = VicarMessage::find($id);
        return view('vicar_messages.edit',compact('message'));
    }

    public function vicar_message_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {

            $message = VicarMessage::find($request->id);

            $a =  $request->validate([
                'subject' => 'required',
                'message_body' => 'required',
            ]);
            $inputData = $request->all();
            $inputData['status'] = 1;
            if($request['image']){

                $fileName = str_replace(' ', '_', $request->subject).'.'.$request['image']->extension();
                $request->image->storeAs('vicar_messages', $fileName);
                $inputData['image'] = 'storage/vicar_messages/'.$fileName;
            }
            $message->update($inputData);
            DB::commit();
             
            return redirect()->route('admin.vicarmessages.list')
                            ->with('success','Vicar Message updated successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }
    }

    public function vicar_message_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $message = VicarMessage::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Vicar message successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Message deletion not success.');
        }
        return response()->json($return);
    }
}