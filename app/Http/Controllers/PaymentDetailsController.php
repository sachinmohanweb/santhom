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
use App\Models\PaymentCategory;

use App\Imports\ContributionsImport;

class PaymentDetailsController extends Controller
{

    public function payment_details_list() : View
    {
        return view('paymentdetails.index',[]);
    }

    public function payment_category_list(Request $request): JsonResponse
    {
        $searchTag = $request->get('search_tag');

        $paymentcategoryQuery = PaymentCategory::query()
            ->where('status', 1)
            ->when($searchTag, function ($query, $searchTag) {
                $query->where('name', 'like', '%' . $searchTag . '%');
            });

        $paymentCategories = $paymentcategoryQuery->orderBy('name')->get()
            ->map(function ($category) {
                return ['id' => $category->id, 'text' => $category->name];
            });

        return response()->json(['results' => $paymentCategories]);

    }
    
    public function payment_details_Datatable()
    {
        if(request()->ajax()) {

            $query = PaymentDetail::select(
                'payment_details.*',
                'payment_categories.name as category_name',
                'family_members.name as head_name',
                'families.family_name'
            )
            ->join('families', 'payment_details.family_id', '=', 'families.id')
            ->join('payment_categories', 'payment_details.category_id', '=', 'payment_categories.id')
            ->join('family_members', 'payment_details.family_head_id', '=', 'family_members.id');

            return datatables()
            ->of($query)
            ->addColumn('DT_RowIndex', function () {
                return '';
            })
            ->addColumn('family', function ($payments) {
                return $payments->family_name;
            })
            ->addColumn('head_of_family', function ($payments) {
                return $payments->head_name;
            })
            ->addColumn('category', function ($payments) {
                return $payments->category_name;
            })
            ->addColumn('action', 'vicar_details.vicar-datatable-action')
            ->rawColumns(['family','head_of_family','category','action'])
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
                'head_id' => 'required',
                'category_id' => 'required',
                'amount' => 'required',
            ]);

            $head = FamilyMember::find($request['head_id']);

            $inputData['family_id'] = $head->family_id;
            $inputData['family_head_id'] = $head->id;
            $inputData['category_id'] = $request['category_id'];
            $inputData['amount'] = $request['amount'];

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
                'head_id' => 'required',
                'category_id' => 'required',
                'amount' => 'required',
            ]);

            $head = FamilyMember::find($request['head_id']);

            $inputData['family_id'] = $head->family_id;
            $inputData['family_head_id'] = $head->id;
            $inputData['category_id'] = $request['category_id'];
            $inputData['amount'] = $request['amount'];


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

    public function admin_contributions_import() : View
    {
        return view('paymentdetails.import');
    }

    public function import_progress_contributions(Request $request)
    {
        $progress = Cache::get('import_progress_contributions', 0);
        return response()->json([
            'progress' => $progress,
        ]);
    }

    public function admin_contributions_import_store(Request $request) : JsonResponse
    {
        $fileData=$request->file('excel_file');

        $contributions_import = new ContributionsImport();
        Excel::import($contributions_import, $fileData);
        $output = $contributions_import->getImportResult();
        return response()->json([$output]);
    }

}
