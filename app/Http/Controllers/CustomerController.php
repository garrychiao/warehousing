<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Customer::orderBy('id', 'asc')->get();
        $show = Customer::first();
        return view('/customer/index')->withLists($lists)->with('show',$show);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/customer/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
      $customer = Customer::create(
      array('customer_id' => $request->customer_id,
            'company_name' => $request->company_name,
            'short_name' => $request->short_name,
            'owner' => $request->owner,
            'contact_person' => $request->contact_person,
            'fax' => $request->fax,
            'invoice' => $request->invoice,
            'check' => $request->check,
            'nationality' => $request->nationality,
            'currency' => $request->currency,
            'remark' => $request->remark,
            'chi_name' => $request->chi_name,
            'eng_name' => $request->eng_name,
            'email' =>$request->email,
            'EIN' => $request->EIN,
            'phone' => $request->phone,
            'cell_phone' => $request->cell_phone,
            'contact_zip_code' => $request->contact_zip_code,
            'contact_address' => $request->contact_address,
            'recieve_zip_code' => $request->recieve_zip_code,
            'recieve_address' => $request->recieve_address,
          ));

      return redirect('/customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $lists = Customer::orderBy('id', 'asc')->get();
      $show = Customer::findOrFail($id);
      return view('/customer/index')->withLists($lists)->with('show',$show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $list = Customer::findOrFail($id);
      return view('customer.edit')->with('customer', $list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $list = Customer::findOrFail($id);

        $list->update([
                'customer_id' => $request->customer_id,
                'company_name' => $request->company_name,
                'short_name' => $request->short_name,
                'owner' => $request->owner,
                'contact_person' => $request->contact_person,
                'fax' => $request->fax,
                'invoice' => $request->invoice,
                'check' => $request->check,
                'nationality' => $request->nationality,
                'currency' => $request->currency,
                'remark' => $request->remark,
                'chi_name' => $request->chi_name,
                'eng_name' => $request->eng_name,
                'email' =>$request->email,
                'EIN' => $request->EIN,
                'phone' => $request->phone,
                'cell_phone' => $request->cell_phone,
                'contact_zip_code' => $request->contact_zip_code,
                'contact_address' => $request->contact_address,
                'recieve_zip_code' => $request->recieve_zip_code,
                'recieve_address' => $request->recieve_address,
        ]);
        return redirect('customer/'.$id)->with('message', 'Customer updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $list = Customer::findOrFail($id);

      $list->delete();

      return \Redirect::route('customer.index')
            ->with('message', 'Customer deleted!');
    }
}
