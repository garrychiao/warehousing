<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $lists = Supplier::orderBy('id', 'asc')->get();
      $show = Supplier::first();
      return view('/supplier/index')->withLists($lists)->with('show',$show);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/supplier/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $supplier = Supplier::create(
      array('supplier_id' => $request->supplier_id,
            'supplier_name' => $request->supplier_name,
            'short_name' => $request->short_name,
            'owner' => $request->owner,
            'phone' => $request->phone,
            'cell_phone' => $request->cell_phone,
            'fax' => $request->fax,
            'email' => $request->email,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'remark' => $request->remark,
          ));

      return redirect('/supplier')->with('message', '新增成功 / Supplier Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $lists = Supplier::orderBy('id', 'asc')->get();
      $show = Supplier::findOrFail($id);
      return view('/supplier/index')->withLists($lists)->with('show',$show);
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
      $list = Supplier::findOrFail($id);

      $list->update([
              'supplier_id' => $request->supplier_id,
              'supplier_name' => $request->supplier_name,
              'short_name' => $request->short_name,
              'owner' => $request->owner,
              'phone' => $request->phone,
              'cell_phone' => $request->cell_phone,
              'fax' => $request->fax,
              'email' => $request->email,
              'zip_code' => $request->zip_code,
              'address' => $request->address,
              'remark' => $request->remark,
      ]);
      return redirect('supplier/'.$id)->with('message', '更新成功 / Supplier updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $list = Supplier::findOrFail($id);

      $list->delete();

      return \Redirect::route('supplier.index')
            ->with('message', 'Supplier deleted!');
    }
}
