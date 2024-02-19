<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use DB;
use Exception;

use App\Models\Family;

class FamilyController extends Controller
{

    public function admin_family_list() : View
    {
        return view('user.family.index',[]);
    }

    public function admin_family_create() : View
    {
        return view('user.family.create',[]);
    }

    public function admin_family_members_list() : View
    {
        return view('user.members.index',[]);
    }

    public function admin_family_store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $a =  $request->validate([
                'family_code' => 'required',
                'family_name' => 'required',
                'family_email' => 'required',
                'head_of_family' => 'required',
                'prayer_group' => 'required',
                'address1' => 'required',
                'address2' => 'required',
                'pincode' => 'required',
            ]);
            Family::create($request->all());
            DB::commit();
             
            return redirect()->route('admin.family.list')
                            ->with('success','Family added successfully.');
        }catch (Exception $e) {

            DB::rollBack();
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['message' =>  $e->getMessage()]);;
        }

    }

    public function edit(Product $product): View
    {
        return view('products.edit',compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        
        $product->update($request->all());
        
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
         
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}
