<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inventory;
use DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $lists = Inventory::orderBy('id', 'asc')->get();
      $show = Inventory::first();
      $img =  DB::table('image_url')->where('img_resource','=',$show->item_id)->get();
      return view('/inventory/index')->withLists($lists)->with('show',$show)->with('img',$img);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/inventory/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $inventory = Inventory::create(
      array('item_id' => $request->item_id,
            'category' => $request->category,
            'item_name' => $request->item_name,
            'standard' => $request->standard,
            'graph_id' => $request->graph_id,
            'barcode' => $request->barcode,
            'inventory' => $request->inventory,
            'unit' => $request->unit,
            'safety_inventory' => $request->safety_inventory,
            'avg_cost' => $request->avg_cost,
            'price1' => $request->price1,
            'price2' => $request->price2,
            'price3' => $request->price3,
            'price4' => $request->price4,
            'price5' => $request->price5,
            'price6' => $request->price6,
            'descriptions' => $request->descriptions,
            'remark' =>$request->remark,
          ));

      return redirect('/inventory');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $lists = Inventory::orderBy('id', 'asc')->get();
      $show = Inventory::findOrFail($id);
      $img =  DB::table('image_url')->where('img_resource','=',$show->item_id)->get();
      return view('/inventory/index')->withLists($lists)->with('show',$show)->with('img',$img);
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
      $list = Inventory::findOrFail($id);

      $list->update([
              'item_id' => $request->item_id,
              'category' => $request->category,
              'item_name' => $request->item_name,
              'standard' => $request->standard,
              'graph_id' => $request->graph_id,
              'barcode' => $request->barcode,
              'inventory' => $request->inventory,
              'unit' => $request->unit,
              'safety_inventory' => $request->safety_inventory,
              'avg_cost' => $request->avg_cost,
              'price1' => $request->price1,
              'price2' => $request->price2,
              'price3' => $request->price3,
              'price4' => $request->price4,
              'price5' => $request->price5,
              'price6' => $request->price6,
              'descriptions' => $request->descriptions,
              'remark' =>$request->remark,
      ]);

      return redirect('inventory/'.$id)->with('message', 'Inventory updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $list = Inventory::findOrFail($id);

      $list->delete();

      return \Redirect::route('inventory.index')
            ->with('message', 'Inventory deleted!');
    }
}
