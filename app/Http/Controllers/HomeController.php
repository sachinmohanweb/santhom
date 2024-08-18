<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

use DB;
use Storage;
use Session;
use Exception;

use App\Models\FamilyMember;
use App\Models\VicarDetail;
use App\Models\VicarMessage;
use App\Models\Event;
use App\Models\NewsAnnouncement;
use App\Models\Download;
use App\Models\Obituary;

class HomeController extends Controller
{
    
    public function admin_index() : View
    {
        return view('index',[]);
    }

    public function admin_dashboard() : View
    {
        return view('dashboard.index',[]);
    }

    public function admin_delete_image(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            if($request['type']=='members'){
                $table = FamilyMember::find($request->table_id);
                if($table->image){
                    $fullPath = public_path($table->image);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $table['image'] = null;
                $table->save();

            }
            if($request['type']=='vicars'){
                $table = VicarDetail::find($request->table_id);
                if($table->photo){
                    $fullPath = public_path($table->photo);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $table['photo'] = null;
                $table->save();
            }
            if($request['type']=='vicar_messages'){
                $table = VicarMessage::find($request->table_id);
                if($table->image){
                    $fullPath = public_path($table->image);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $table['image'] = null;
                $table->save();
            }
            if($request['type']=='events'){
                $table = Event::find($request->table_id);
                if($table->image){
                    $fullPath = public_path($table->image);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $table['image'] = null;
                $table->save();
            }
            if($request['type']=='news'){
                $table = NewsAnnouncement::find($request->table_id);
                if($table->image){
                    $fullPath = public_path($table->image);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $table['image'] = null;
                $table->save();
            }
            if($request['type']=='downloads'){
                $table = Download::find($request->table_id);
                if($table->file){
                    $fullPath = public_path($table->file);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $table['file'] = null;
                $table->save();
            }
            if($request['type']=='obituary'){
                $table = Obituary::find($request->table_id);
                if($table->photo){
                    $fullPath = public_path($table->photo);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $table['photo'] = null;
                $table->save();
            }

            DB::commit();
            Session::flash('success', 'Image successfully deleted.');
            $return['status'] = "success";
            $return['message'] = "Image successfully deleted";

         }catch (Exception $e) {
            DB::rollBack();
            Session::flash('error',  $e->getMessage());
            $return['status'] = $e->getMessage();
            $return['message'] = 'Image deletion not success';
        }
        return response()->json($return);
    }

    public function admin_databse_backup()
    {
        $filename = 'santhom_connect_db_' . date('d_m_Y') . '.sql';

        $path = storage_path('app/' . $filename);

        $command = sprintf('mysqldump --user=%s --password=%s --host=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_DATABASE'),
            $path
        );

        exec($command);

        return response()->download($path)->deleteFileAfterSend(true);
    }
    
}
