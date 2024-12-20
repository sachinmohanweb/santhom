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

use App\Models\Obituary;
use App\Models\FamilyMember;

use App\Notifications\NotificationPusher; 

class ObituaryController extends Controller
{

    public function obituary_list() : View
    {
        return view('obituary.index',[]);
    }
    public function obituary_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(Obituary::select('*')->orderBy('date_of_death','desc')->orderBy('display_till_date','desc'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('image', function ($obituary) {

                if ($obituary->photo) {
                    return '<img  class="img-70 rounded-circle" src="' . asset($obituary->photo) . '"  alt="Family Member Image" style="height: 70px;">';
                } else {
                    $nameWords = explode(' ', $obituary->name_of_member);
                    $nameLetters = '';

                    foreach ($nameWords as $word) {
                        $nameLetters .= substr($word, 0, 1);
                        if(strlen($nameLetters) >= 2) {
                            break;
                        }
                    }

                    if(strlen($nameLetters) == 1) {
                        $nameLetters = substr($obituary->name, 0, 2);
                    }

                    $backgroundColors = ['#ff7f0e', '#2ca02c', '#1f77b4', '#d62728', '#9467bd'];
                    $backgroundColor = $backgroundColors[array_rand($backgroundColors)];

                    return '<div class="img-70 rounded-circle text-center" style="height: 70px; width: 70px; background-color: ' . $backgroundColor . '; color: white; line-height: 70px; font-size: 24px;">' . $nameLetters . '</div>';
                }
            })
            ->addColumn('created', function ($news) {
                return \Carbon\Carbon::parse($news['created_at'])->format('d-m-Y');
            })
            ->addColumn('action', 'obituary.obituary-datatable-action')
            ->rawColumns(['image','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function obituary_create() : View
    {
        $obituary = Obituary::all();
        return view('obituary.create',compact('obituary'));
    }

    public function obituary_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {

            $a =  $request->validate([
                'member_id' => 'required',
                'date_of_death' => 'required',
                'display_till_date' => 'required',
            ]);

            $inputData = $request->all();

            $member_name = FamilyMember::find($request['member_id'])->name;
            $inputData = $request->all();
            $inputData['name_of_member'] = $member_name;

            if($request['photo']){

                $fileName = str_replace(' ', '_', $member_name).'_'.time().'.'.$request['photo']->extension();
                $request->photo->storeAs('obituary', $fileName);
                $inputData['photo'] = 'storage/obituary/'.$fileName;
            }else{
                $member = FamilyMember::find($request['member_id']);
                $inputData['photo'] = $member->image;
            }
            $obituary = Obituary::create($inputData);

            $member = FamilyMember::where('id',$request['member_id'])->first();
            $member->date_of_death = $request['date_of_death'];
            $member->save();

            DB::commit();

            if($obituary->photo !== null) {
                $obituary->photo = asset('/') . $obituary->photo;
            }
            $today = date('Y-m-d');
            if($request['date_of_death']== $today){

                $push_data = [];
                $push_data['devicesIds']    =  FamilyMember::whereNotNull('refresh_token')->pluck('refresh_token')->toArray();
                $push_data['title']         =   'With deep sorrow, we announce the passing of '.$member['name'];
                $push_data['body']          =   $member->family_name;

                $push_data['route']         =   'obituaries';
                $push_data['id']            =   $obituary['id'];
                $push_data['category']      =   'Obituary';

                $push_data['data1']         =   'With deep sorrow, we announce the passing of '.$member['name'];
                $push_data['data2']         =   $member->family_name;
                $push_data['data3']         =   $obituary['date_of_death'];
                $push_data['data4']         =   $obituary['funeral_date']?'Date of Funeral : '.$obituary['funeral_date']:null;
                $push_data['data5']         =   $obituary['funeral_time']?'Time of funeral : '.$obituary['funeral_time']:null;
                $push_data['data6']         =   $obituary['notes'];
                $push_data['image1']        =   $obituary['photo'];
                $push_data['image2']        =   null;

                $pusher = new NotificationPusher();
                $pusher->push($push_data);
            }

             
            return redirect()->route('admin.obituary.list')
                            ->with('success','Obituary details added.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function obituary_show($id) : View
    {
        $obituary = Obituary::where('id',$id)->first();

        return view('obituary.details',compact('obituary'));
    }

    public function obituary_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $obituary = Obituary::find($request->id);
            $a =  $request->validate([
                'member_id' => 'required',
                'date_of_death' => 'required',
                'display_till_date' => 'required',
            ]);

            $inputData = $request->all();
            
            $member_name = FamilyMember::find($request['member_id'])->name;
            $inputData = $request->all();
            $inputData['name_of_member'] = $member_name;

            if($request['photo']){

                $fileName = str_replace(' ', '_', $member_name).'_'.$request->id.'_'.time().'.'.$request['photo']->extension();
                $request->photo->storeAs('obituary', $fileName);
                $inputData['photo'] = 'storage/obituary/'.$fileName;
            }else{
                $member = FamilyMember::find($request['member_id']);
                $inputData['photo'] = $member->image;
            }
            $obituary->update($inputData);

            $member = FamilyMember::find($request['member_id']);
            $member->date_of_death = $request['date_of_death'];
            $member->save();
            
            DB::commit();

            return redirect()->back()
                    ->with('success','Obituary details updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function obituary_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $obituary = Obituary::where('id',$request->id)->first();

            $member = FamilyMember::find($obituary['member_id']);
            $member->date_of_death = null;
            $member->save();

            $obituary->delete();
            DB::commit();
            Session::flash('success', 'Obituary deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Obituary deletion not success.');
        }
        return response()->json($return);
    }

}
