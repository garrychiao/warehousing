<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\CommercialInvoiceInventory;
use App\ProformaInvoiceInventory;
use App\InventoryKitMember;
use DB;
use Auth;

class InventoryController extends Controller
{
    public function __construct()
    {
      $this->middleware('emp_rights:inventory');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      /*
      $lists = Inventory::select('id',
                DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from proforma_invoice_inventories a1 join proforma_invoices a2 on a1.proforma_invoice_id = a2.id WHERE a1.inventory_id = inventories.id and a2.due_date >= '".date('Y-m-d')."' and a2.converted = false and a1.inventory_id IS NOT NULL) as preserved_inventory"),
                DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from commercial_invoice_inventories a1 join commercial_invoices a2 on a1.commercial_invoice_id = a2.id WHERE a1.inventory_id = inventories.id and a1.inventory_id IS NOT NULL) as shipped_inventory"),
                DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from purchase_inventory_records a1 join purchase_records a2 on a1.purchase_records_id = a2.id WHERE a1.inventory_id = inventories.id and a2.delivery_date >= '".date('Y-m-d')."' and a1.inventory_id IS NOT NULL) as incoming_inv"))
                ->orderBy('id', 'asc')->get();
      //Update invenotry datas
      foreach($lists as $list){
        DB::table('inventories')
              ->where('id','=',$list->id)
              ->update(['preserved_inv' => $list->preserved_inventory,
                        'incoming_inv' => $list->incoming_inv,
                        'shipped_inv' => $list->shipped_inventory]);
      }
      //select proforma inventory "kits" part and add to the above before due_date for each item
      $lists_proforma_kits = ProformaInvoiceInventory::select('kits_id','quantity')->join('proforma_invoices', 'proforma_invoices.id', '=', 'proforma_invoice_inventories.proforma_invoice_id')
                ->where('due_date','>=',date('Y-m-d'))->where('converted','=',false)->whereNotNull('kits_id')->get();
      //select each commercial inventory "kits" part to substract to the purchased
      $lists_commercial_kits = CommercialInvoiceInventory::select('kits_id','quantity')->join('commercial_invoices', 'commercial_invoices.id', '=', 'commercial_invoice_inventories.commercial_invoice_id')
                ->whereNotNull('kits_id')->get();

      foreach ($lists_proforma_kits as $p_kits) {
        $find_kits = InventoryKitMember::select('inventory_id','inventory_name','quantity')->where('kits_id','=',$p_kits->kits_id)->get();
        foreach ($find_kits as $find) {
          DB::table('inventories')
                ->where('id','=',$find->inventory_id)
                ->increment('preserved_inv', $find->quantity*$p_kits->quantity);
        }
      }
      foreach ($lists_commercial_kits as $c_kits) {
        $find_kits = InventoryKitMember::select('inventory_id','inventory_name','quantity')->where('kits_id','=',$c_kits->kits_id)->get();
        foreach ($find_kits as $find) {
          DB::table('inventories')
                ->where('id','=',$find->inventory_id)
                ->increment('shipped_inv', $find->quantity*$c_kits->quantity);
        }
      }
      */
      $lists = Inventory::orderBy('display_order', 'asc')->paginate(10);
      $inventory = Inventory::select('id','item_name','display_order')->orderBy('display_order', 'asc')->get();
      $alert = Inventory::select('item_id','item_name','inventory','safety_inventory')->whereColumn('safety_inventory','>','inventory')
                ->orderBy('display_order')->get();
      return view('/inventory/index')->withLists($lists)->with('img',null)->with('inventory',$inventory)->with('alert',$alert);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventory = Inventory::select('display_order','item_id','item_name')->orderby('display_order','asc')->get();
        return view('/inventory/create')->with('inventory',$inventory);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->order_setup == false){
        $display_order = $request->display_order+1;
        Inventory::where('display_order','>',$request->display_order)->increment('display_order');
      }else{
        $display_order = Inventory::max('display_order')+1;
      }
      $inventory = Inventory::create(
      array('item_id' => $request->item_id,
            'category' => $request->category,
            'item_name' => $request->item_name,
            'display_order' => $display_order,
            'chi_item_name' => $request->chi_item_name,
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
            'unit_weight' => $request->unit_weight,
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
      $lists = Inventory::select('*',
                DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from proforma_invoice_inventories a1 join proforma_invoices a2 on a1.proforma_invoice_id = a2.id WHERE a1.inventory_id = inventories.id and a2.due_date >= '".date('Y-m-d')."' and a2.converted = false and a1.inventory_id IS NOT NULL) as preserved_inventory"),
                DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from commercial_invoice_inventories a1 join commercial_invoices a2 on a1.commercial_invoice_id = a2.id WHERE a1.inventory_id = inventories.id and a1.inventory_id IS NOT NULL) as shipped_inventory"))
                ->where('id','=',$id)->paginate(10);
      $inventory = Inventory::select('id','item_name')->orderBy('item_name')->get();
      $alert = Inventory::select('item_id','item_name','inventory','safety_inventory')->where('safety_inventory','>','inventory')
                ->orderBy('id')->get();

      return view('/inventory/index')->withLists($lists)->with('img',null)->with('inventory',$inventory)->with('alert',$alert);
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
      //display_order setup
      $display_order = $request->display_order+1;
      if($list->display_order != $display_order && $list->display_order!=0){
        if($list->display_order > $display_order){//put forward
          Inventory::whereBetween('display_order',[$display_order, $list->display_order])->increment('display_order');
        }elseif ($list->display_order < $display_order) {//put back
          $display_order = $request->display_order;
          Inventory::whereBetween('display_order',[$list->display_order , $display_order])->decrement('display_order');
        }
      }


      $list->update([
              'item_id' => $request->item_id,
              'category' => $request->category,
              'chi_item_name' => $request->chi_item_name,
              'item_name' => $request->item_name,
              'display_order' => $display_order,
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
              'unit_weight' => $request->unit_weight,
              'descriptions' => $request->descriptions,
              'remark' =>$request->remark,
      ]);

      return redirect('inventory')->with('message', 'Inventory updated!');
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
      Inventory::where('display_order','>',$list->display_order)->decrement('display_order');
      $list->delete();

      return \Redirect::route('inventory.index')
            ->with('message', 'Inventory deleted!');
    }

    public function deviation_index(){
      if(Auth::user()->administrator==false){
        return view('unauthorized');
      }else{
        $deviation = DB::table('inventory_deviation')
          ->join('inventories','inventory_deviation.inventory_id','=','inventories.id')
          ->select('inventory_deviation.*','inventories.item_id','inventories.item_name')
          ->get();
        $inventory = Inventory::select('id','item_id','item_name')->get();
        return view('inventory/deviation')->with('inventory',$inventory)->with('deviation',$deviation);
      }
    }

    public function deviation_create(Request $request){
      if($request->type == "minus"){
        $deviation = -$request->quantity;
      }else{
        $deviation = $request->quantity;
      }

      DB::table('inventory_deviation')->insert([
        'inventory_id' => $request->inventory_id,
        'deviation' => $deviation,
        'date' => $request->date
      ]);

      return redirect('inventory_deviation');
    }

    public function deviation_delete(Request $request){

      DB::table('inventory_deviation')->where('id','=',$request->id)->delete();
      return redirect('inventory_deviation');

    }
}
