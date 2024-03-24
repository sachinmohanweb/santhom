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

use App\Models\MemoryDay;
use App\Models\MemoryType;

class MemoriesController extends Controller
{

    public function admin_memories_list() : View
    {
        return view('memories.index',[]);
    }
    public function admin_memories_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(MemoryDay::select('*')->where('status',1))
            ->addColumn('action', 'memories.memories-datatable-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function admin_memories_create() : View
    {
        $MemoryType = MemoryType::all();

        return view('memories.create',compact('MemoryType'));
    }

    public function admin_memories_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'memory_type_id' => 'required',
                'date' => 'required',
                'title' => 'required',
            ]);

            $MemoryDay = MemoryDay::create($request->all());
            DB::commit();
             
            return redirect()->route('admin.memories.list')
                            ->with('success',"Success! Memory has been successfully added");
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function admin_memories_show($id) : View
    {
        $Memory = MemoryDay::where('id',$id)->first();
        $MemoryType = MemoryType::all();

        return view('memories.details',compact('Memory','MemoryType'));
    }

    public function admin_memories_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $Memory = MemoryDay::find($request->id);
            $a =  $request->validate([
                'memory_type_id' => 'required',
                'date' => 'required',
                'title' => 'required',
            ]);
            $Memory->update($request->all());
            DB::commit();

            return redirect()->back()
                    ->with('success','Memory successfully updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function admin_memories_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $Memory = MemoryDay::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Memory successfully deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Memory deletion not success.');
        }
        return response()->json($return);
    }
}
