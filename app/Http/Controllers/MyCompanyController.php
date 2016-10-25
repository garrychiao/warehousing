<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MyCompany;
use Image;
use DB;

class MyCompanyController extends Controller
{
  public function __construct()
  {
    $this->middleware('emp_rights:administrator');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $show = MyCompany::first();
        return view('/mycompany/index')->with('show',$show);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $customer = MyCompany::create(
      array(
        'name' => $request->name,
        'owner' => $request->owner,
        'eng_name' => $request->eng_name,
        'EIN' => $request->EIN,
        'contact_person' => $request->contact_person,
        'eng_address' => $request->eng_address,
        'address' => $request->address,
        'phone' => $request->phone,
        'cell_phone' => $request->cell_phone,
        'fax' => $request->fax,
        'quotation' => $request->quotation,
        'email' => $request->email,
        'website' => $request->website,
      ));

      return redirect('/mycompany')->with('message', 'My Company created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $list = MyCompany::findOrFail($id);

      $list->update([
              'name' => $request->name,
              'owner' => $request->owner,
              'eng_name' => $request->eng_name,
              'EIN' => $request->EIN,
              'contact_person' => $request->contact_person,
              'eng_address' => $request->eng_address,
              'address' => $request->address,
              'phone' => $request->phone,
              'cell_phone' => $request->cell_phone,
              'fax' => $request->fax,
              'quotation' => $request->quotation,
              'email' => $request->email,
              'website' => $request->website,
      ]);

      return \Redirect::route('mycompany.index')
            ->with('message', 'My Company updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
