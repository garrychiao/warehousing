<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Inventory;
use App\InventoryKit;
use App\InventoryKitMember;

class setKitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $lists = Inventory::orderBy('id', 'asc')->get();
      return view('inventory/setKits')->with('lists',$lists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $records = InventoryKit::orderby('id')->get();
        $records_inv = InventoryKitMember::get();
        //leftjoin('inventory_kit_members','inventory_kits.id','=','inventory_kit_members.kits_id')
        //->orderby('inventory_kits.id')->get();
        return view('inventory/showKits')->with('records',$records)->with('records_inv',$records_inv);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $inventorykit = InventoryKit::create(
      array('kits_id' => $request->kits_id,
            'kits_name' => $request->kits_name,
            'kits_description' => $request->kits_description,
            'kits_weight' => $request->kits_weight,
            'price1' => $request->price1,
            'price2' => $request->price2,
            'price3' => $request->price3,
            'price4' => $request->price4,
            'price5' => $request->price5,
            'price6' => $request->price6
          ));
      $recordID = InventoryKit::select('id')->where('kits_id','=',$request->kits_id)->first();
      //the inventory amount part
      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        $kitMembers = InventoryKitMember::create(array(
          'kits_id' => $recordID->id,
          'inventory_id' => $request->item_id[$i],
          'inventory_name' => $request->item_name[$i],
          'quantity' => $request->quantity[$i],
        ));
      }

      return redirect('/setKits')->with('message', 'Success!');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $del_kits = InventoryKit::findOrFail($id)->delete();
      $del_kits_inv = InventoryKitMember::where('kits_id','=',$id)->delete();

      return redirect('/setKits')->with('message', 'Kits deleted!');
    }
}
