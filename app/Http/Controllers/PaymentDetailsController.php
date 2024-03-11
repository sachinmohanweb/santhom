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

use App\Models\PaymentDetail;
use App\Models\FamilyMember;

class PaymentDetailsController extends Controller
{

    public function payment_details_list() : View
    {
        return view('paymentdetails.index',[]);
    }
    public function payment_details_Datatable()
    {
        if(request()->ajax()) {
            return datatables()
            ->of(PaymentDetail::select('*'))
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('member_name', function ($payments) {
                return $payments['member'];
            })
           
            ->addColumn('action', 'paymentdetails.paymentdetails-datatable-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('index');
    }

    public function payment_details_create() : View
    {
        return view('paymentdetails.create');
    }

    public function payment_details_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {

            $a =  $request->validate([
                'member_id' => 'required',
                'purpose' => 'required',
                'date' => 'required',
                'amount' => 'required',
            ]);

            $member_name = FamilyMember::find($request['member_id'])->name;
            $inputData = $request->all();
            $inputData['member'] = $member_name;

            PaymentDetail::create($inputData);
            DB::commit();
             
            return redirect()->route('admin.paymentdetails.list')
                            ->with('success','Payment details added.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function payment_details_show($id) : View
    {
        $PaymentDetail = PaymentDetail::where('id',$id)->first();

        return view('paymentdetails.details',compact('PaymentDetail'));
    }

    public function payment_details_update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $paymentDetail = PaymentDetail::find($request->id);
            $a =  $request->validate([
                'member_id' => 'required',
                'purpose' => 'required',
                'date' => 'required',
                'amount' => 'required',
            ]);

            $member_name = FamilyMember::find($request['member_id'])->name;
            $inputData = $request->all();
            $inputData['member'] = $member_name;


            $paymentDetail->update($inputData);
            DB::commit();

            return redirect()->back()
                    ->with('success','Payment details updated.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->with('error',$e->getMessage());
        }

    }

    public function payment_details_delete(Request $request) : JsonResponse
    {
        DB::beginTransaction();
        try{
            $paymentDetail = PaymentDetail::where('id',$request->id)->delete();
            DB::commit();
            Session::flash('success', 'Payment detail deleted.');
            $return['status'] = "success";

         }catch (Exception $e) {

            DB::rollBack();
            $return['status'] = $e->getMessage();
            Session::flash('error', 'Payment detail deletion not success.');
        }
        return response()->json($return);
    }

}
