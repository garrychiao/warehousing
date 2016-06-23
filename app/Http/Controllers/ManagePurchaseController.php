<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PurchaseRecordRequest;
use App\Http\Controllers\Controller;
use App\PurchaseRecord;
use App\Inventory;
use App\Supplier;
use App\MyCompany;
use App\PurchaseInventoryRecord;
use DB;

class ManagePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::distinct()->select('item_id','item_name','id')->orderBy('id', 'asc')->get();
        $supplier = Supplier::distinct()->select('supplier_name','id')->orderBy('id','asc')->get();
        $mycompany = MyCompany::firstOrNew(['id' => '1']);
        $idcount = PurchaseRecord::select('created_at')->whereDate('created_at','=',date("Y-m-d"))->count()+1;
        return view('/purchase/index')->with('inventory',$inventory)
        ->with('supplier',$supplier)->with('mycompany',$mycompany)->with('form_id',$idcount);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $records = PurchaseRecord::join('suppliers','suppliers.id','=','purchase_records.supplier_id')
          ->select('purchase_records.*','suppliers.supplier_name')
          ->addSelect(DB::raw("(SELECT count(*) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as count"))
          ->addSelect(DB::raw("(SELECT sum(total) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as amount"))
          ->orderby('purchase_records.id')->get();
      return view('/purchase/records')->with('records',$records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRecordRequest $request)
    {
      //the main record part
      $purchase = PurchaseRecord::create(
      array('supplier_id' => $request->supplier_id,
            'order_id' => $request->order_id,
            'purchase_date' => $request->purchase_date,
            'delivery_date' => $request->delivery_date,
            'payment_terms' => $request->payment_terms,
            'delivery_address' => $request->delivery_address,
            'packing' => $request->packing,
            'shipping_sample' => $request->shipping_sample,
            'undertaker' => $request->undertaker,
            'precautions' => $request->precautions
          ));
      $recordID = PurchaseRecord::select('id')->where('order_id','=',$request->order_id)->first();
      //the inventory amount part
      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        $PurchaseInventory = PurchaseInventoryRecord::create(array(
          'purchase_records_id' => $recordID->id,
          'inventory_id' => $request->item_id[$i],
          'quantity' => $request->quantity[$i],
          'unit_price' => $request->unit_price[$i],
          'total' => $request->total[$i],
          'remark' => $request->remark[$i],
        ));
        $Inventory = Inventory::find($request->item_id[$i]);
        //add to inventory to item
        $totalInv = $Inventory->inventory+$request->quantity[$i];
        //calculating the total cost of the item
        $totalCost = $Inventory->avg_cost*$Inventory->inventory + $request->total[$i];
        //calculating the average cost
        $avgCost = $totalCost/$totalInv;
        //update
        $Inventory->inventory = $totalInv;
        $Inventory->avg_cost = $avgCost;
        $Inventory->save();
      }

      return redirect('/purchase/create')->with('message', 'Purchase success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      $records = PurchaseRecord::join('suppliers','suppliers.id','=','purchase_records.supplier_id')
      ->select('purchase_records.*','suppliers.supplier_name')
      ->where('purchase_records.id','=',$id)->first();
      $inventory = PurchaseInventoryRecord::join('inventories','inventories.id','=','purchase_inventory_records.inventory_id')
      ->select('purchase_inventory_records.*','inventories.item_id','inventories.item_name')
      ->where('purchase_records_id','=',$id)->get();
      $total = PurchaseInventoryRecord::where('purchase_records_id','=',$id)->sum('total');
      return view('/purchase/show')->with('inventory',$inventory)->with('records',$records)
              ->with('mycompany',$mycompany)->with('total',$total);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $records = PurchaseRecord::join('suppliers','suppliers.id','=','purchase_records.supplier_id')
      ->select('purchase_records.*','suppliers.supplier_name')
      ->where('purchase_records.id','=',$id)->first();
      $inventory = PurchaseInventoryRecord::join('inventories','inventories.id','=','purchase_inventory_records.inventory_id')
      ->select('purchase_inventory_records.*','inventories.item_id','inventories.item_name')
      ->where('purchase_records_id','=',$id)->get();
      $select_inventory = Inventory::distinct()->select('item_id','item_name','id')->orderBy('id', 'asc')->get();
      $total = PurchaseInventoryRecord::where('purchase_records_id','=',$id)->sum('total');

      $supplier = Supplier::distinct()->select('supplier_name','id')->orderBy('id','asc')->get();
      $mycompany = MyCompany::firstOrNew(['id' => '1']);

      //echo $inventory;
      return view('/purchase/edit')->with('inventory',$inventory)->with('records',$records)
            ->with('mycompany',$mycompany)->with('total',$total)->with('supplier',$supplier)
            ->with('select_inventory',$select_inventory);
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
        $purchase_records = PurchaseRecord::find($id);
        //update basic purchase records
        $purchase_records->update([
                'supplier_id' => $request->supplier_id,
                'order_id' => $request->order_id,
                'purchase_date' => $request->purchase_date,
                'delivery_date' => $request->delivery_date,
                'payment_terms' => $request->payment_terms,
                'delivery_address' => $request->delivery_address,
                'packing' => $request->packing,
                'shipping_sample' => $request->shipping_sample,
                'undertaker' => $request->undertaker,
                'precautions' =>$request->precautions,
        ]);

        $del_inventory = PurchaseInventoryRecord::where('purchase_records_id','=',$id)->get();
        foreach ($del_inventory as $del) {
          //echo $del->inventory_id;
          $Inventory = Inventory::find($del->inventory_id);
          //calculating the total cost of the item
          $del_totalCost = $Inventory->avg_cost*$Inventory->inventory - $del->total;
          //add to inventory to item
          $del_totalInv = $Inventory->inventory-$del->quantity;
          //calculating the average cost
          if($del_totalInv != 0){
            $del_avgCost = $del_totalCost/$del_totalInv;
          }else{
            $del_totalInv=0;
            $del_totalCost=0;
            $del_avgCost=0;
          }
          //update
          $Inventory->inventory = $del_totalInv;
          $Inventory->avg_cost = $del_avgCost;
          $Inventory->save();
        }
        $del_inventory = PurchaseInventoryRecord::where('purchase_records_id','=',$id);
        $del_inventory->delete();
        //the inventory amount part
        $length = count($request->item_id);
        for($i=0 ; $i<$length ; $i++){
          $PurchaseInventory = PurchaseInventoryRecord::create(array(
            'purchase_records_id' => $id,
            'inventory_id' => $request->item_id[$i],
            'quantity' => $request->quantity[$i],
            'unit_price' => $request->unit_price[$i],
            'total' => $request->total[$i],
            'remark' => $request->remark[$i],
          ));
          $Inventory = Inventory::find($request->item_id[$i]);
          //add to inventory to item
          $totalInv = $Inventory->inventory+$request->quantity[$i];
          //calculating the total cost of the item
          $totalCost = $Inventory->avg_cost*$Inventory->inventory + $request->total[$i];
          //calculating the average cost
          $avgCost = $totalCost/$totalInv;
          //update
          $Inventory->inventory = $totalInv;
          $Inventory->avg_cost = $avgCost;
          $Inventory->save();
        }

        return redirect('/purchase/create')->with('message', 'Success!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $del_purchase_records = PurchaseRecord::where('id','=',$id)->delete();
      $del_inventory_records = PurchaseInventoryRecord::where('purchase_records_id','=',$id)->get();
      foreach ($del_inventory_records as $del) {
        //echo $del->inventory_id;
        $Inventory = Inventory::find($del->inventory_id);
        //calculating the total cost of the item
        $del_totalCost = $Inventory->avg_cost*$Inventory->inventory - $del->total;
        //add to inventory to item
        $del_totalInv = $Inventory->inventory-$del->quantity;
        //calculating the average cost
        if($del_totalInv != 0){
          $del_avgCost = $del_totalCost/$del_totalInv;
        }else{
          $del_totalInv=0;
          $del_totalCost=0;
          $del_avgCost=0;
        }
        //update
        $Inventory->inventory = $del_totalInv;
        $Inventory->avg_cost = $del_avgCost;
        $Inventory->save();
      }
      $del_inventory_records = PurchaseInventoryRecord::where('purchase_records_id','=',$id);
      $del_inventory_records->delete();

      return redirect('/purchase/create')->with('message', 'Deleted!');

    }
}
