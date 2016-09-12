<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\InventoryKit;
use App\InventorykitMember;
use App\Customer;
use App\MyCompany;
use DB;
use App\CommercialInvoice;
use App\CommercialInvoiceInventory;

class CommercialInvoiceController extends Controller
{
  public function __construct()
  {
    $this->middleware('emp_rights:commercial');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','inventory','unit_weight','price1','price2','price3','price4','price5','price6','id')->orderBy('id', 'asc')->get();
      $inventory_kits = InventoryKit::distinct()->get();
      $customer = Customer::distinct()->orderBy('id','asc')->get();
      $idcount = CommercialInvoice::select('created_at')->whereDate('created_at','=',date("Y-m-d"))->count()+1;
      return view('shippment/commercial/index')->with('inventory',$inventory)->with('inventory_kits',$inventory_kits)
      ->with('customer',$customer)->with('form_id',$idcount)->with('mycompany',$mycompany);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $records = CommercialInvoice::join('customers','customers.id','=','commercial_invoices.customer_id')
          ->select('commercial_invoices.*','customers.chi_name','customers.contact_person')
          ->orderby('commercial_invoices.id')->get();
      return view('/shippment/commercial/records')->with('records',$records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $commercial = CommercialInvoice::create(
      array('customer_id' => $request->customer_id,
            'order_id' => $request->order_id,
            'create_date' => $request->create_date,
            'export_date' => $request->export_date,
            'terms_of_sale' => $request->terms_of_sale,
            'reference' => $request->reference,
            'currency' => $request->currency,
            'customer_id' => $request->customer_id,
            'exporter' => $request->exporter,
            'manufacture_country' => $request->manufacture_country,
            'consignee' => $request->consignee,
            'notify_party' => $request->notify_party,
            'destination_country' => $request->destination_country,
            'airwaybill_number' => $request->airwaybill_number,
            'packages' => $request->packages,
            'cost_shipping' => $request->cost_shipping,
            'cost_insurance' => $request->cost_insurance,
            'cost_additional' => $request->cost_additional,
            'final_total' => $request->final_total
          ));
      $recordID = CommercialInvoice::select('id')->where('order_id','=',$request->order_id)->first();

      if(isset($request->proforma_id)){
        $converted = DB::update('update proforma_invoices set converted = true where id = ?', [$request->proforma_id]);
      }
      //the inventory amount part
      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        //$check_is_kit = strstr($request->item_id[$i],'K',true);
        if(strpos($request->item_id[$i],"K")){
          $kits_id = strstr($request->item_id[$i],'K',true);
          $PurchaseInventory = CommercialInvoiceInventory::create(array(
            'inventory_id' => null,
            'kits_id'=> $kits_id,
            'commercial_invoice_id' => $recordID->id,
            'quantity' => $request->quantity[$i],
            'unit_price' => $request->unit_price[$i],
            'total' => $request->total[$i],
            'weight' => $request->weight[$i],
            'description' => $request->description[$i],
          ));
          /*$kit_qty = InventoryKitMember::select('inventory_id','quantity')->where('kits_id','=',$kits_id)->get();
          foreach ($kit_qty as $qty) {
            $Inventory = Inventory::find($qty->inventory_id);
            //add to inventory to item
            $totalInv = $Inventory->inventory-$qty->quantity;
            //update
            $Inventory->inventory = $totalInv;
            $Inventory->save();
          }*/
        }else{
          $PurchaseInventory = CommercialInvoiceInventory::create(array(
            'inventory_id' => $request->item_id[$i],
            'kits_id'=> null,
            'commercial_invoice_id' => $recordID->id,
            'quantity' => $request->quantity[$i],
            'unit_price' => $request->unit_price[$i],
            'total' => $request->total[$i],
            'weight' => $request->weight[$i],
            'description' => $request->description[$i],
          ));
          /*
          $Inventory = Inventory::find($request->item_id[$i]);
          //add to inventory to item
          $totalInv = $Inventory->inventory-$request->quantity[$i];
          //update
          $Inventory->inventory = $totalInv;
          $Inventory->save();
          */
        }
      }
      return redirect('/shippment/commercial/create')->with('message', 'Success!');
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
      $mycompany_img = DB::table('image_url')->where('img_resource','=','mycompany')->first();
      $records = CommercialInvoice::findOrFail($id);
      $inventory = CommercialInvoiceInventory::join('inventories','inventories.id','=','commercial_invoice_inventories.inventory_id')
            ->select('commercial_invoice_inventories.*','inventories.item_id','inventories.descriptions')
            ->where('commercial_invoice_id', $id)->get();
      $inventory_kits_records = CommercialInvoiceInventory::join('inventory_kits','inventory_kits.id','=','commercial_invoice_inventories.kits_id')
            ->select('commercial_invoice_inventories.*','inventory_kits.kits_name','inventory_kits.kits_id as item_id','inventory_kits.kits_description')
            ->whereNotNull('commercial_invoice_inventories.kits_id')->where('commercial_invoice_id','=',$id)->get();
      $total = CommercialInvoiceInventory::select(DB::raw('SUM(total) as total'),DB::raw('SUM(weight) as weight'),DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(unit_price) as unit_price'))
      ->where('commercial_invoice_id','=',$id)->first();
      $final_total = $records->cost_shipping+$records->cost_insurance+$records->cost_additional+$total->total;

      return view('/shippment/commercial/show')->with('records',$records)
      ->with('total',$total)->with('inventory',$inventory)->with('mycompany_img',$mycompany_img)
      ->with('inventory_kits_records',$inventory_kits_records)
      ->with('mycompany',$mycompany)->with('final_total',$final_total);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','inventory','unit_weight','price1','price2','price3','price4','price5','price6','id')->orderBy('id', 'asc')->get();
      $customer = Customer::distinct()->orderBy('id','asc')->get();
      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      $inventory_kits = InventoryKit::distinct()->get();
      $inventory_kits_records = CommercialInvoiceInventory::join('inventory_kits','inventory_kits.id','=','commercial_invoice_inventories.kits_id')
              ->select('commercial_invoice_inventories.*','inventory_kits.kits_name')
              ->whereNotNull('commercial_invoice_inventories.kits_id')->where('commercial_invoice_id','=',$id)->get();
      $records = CommercialInvoice::findOrFail($id);
      $rec_inventory = CommercialInvoiceInventory::join('inventories','inventories.id','=','commercial_invoice_inventories.inventory_id')
      ->select('commercial_invoice_inventories.*','inventories.item_name','inventories.item_id','inventories.descriptions')
      ->where('commercial_invoice_id', $id)->get();
      $total = CommercialInvoiceInventory::select(DB::raw('SUM(total) as total'),DB::raw('SUM(weight) as weight'),DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(unit_price) as unit_price'))
      ->where('commercial_invoice_id','=',$id)->first();
      $final_total = $records->cost_shipping+$records->cost_insurance+$records->cost_additional+$total->total;

      return view('/shippment/commercial/edit')->with('records',$records)
              ->with('total',$total)->with('inventory',$inventory)->with('customer',$customer)
              ->with('inventory_kits',$inventory_kits)->with('inventory_kits_records',$inventory_kits_records)
              ->with('final_total',$final_total)->with('rec_inventory',$rec_inventory)->with('mycompany',$mycompany);
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
      $commercial_records = CommercialInvoice::find($id);
      //basic updates
      $commercial_records->update([
              'customer_id' => $request->customer_id,
              'order_id' => $request->order_id,
              'create_date' => $request->create_date,
              'export_date' => $request->export_date,
              'terms_of_sale' => $request->terms_of_sale,
              'reference' => $request->reference,
              'currency' => $request->currency,
              'customer_id' => $request->customer_id,
              'exporter' => $request->exporter,
              'manufacture_country' => $request->manufacture_country,
              'consignee' => $request->consignee,
              'notify_party' => $request->notify_party,
              'destination_country' => $request->destination_country,
              'airwaybill_number' => $request->airwaybill_number,
              'packages' => $request->packages,
              'cost_shipping' => $request->cost_shipping,
              'cost_insurance' => $request->cost_insurance,
              'cost_additional' => $request->cost_additional,
              'final_total' => $request->final_total
      ]);
      //delete former inventory inputs and insert new ones

      /*$del_inventory = CommercialInvoiceInventory::where('commercial_invoice_id','=',$id)->get();

      foreach ($del_inventory as $del) {
        //echo $del->inventory_id;
        $Inventory = Inventory::find($del->inventory_id);
        //add to inventory to item
        $del_totalInv = $Inventory->inventory+$del->quantity;
        //update
        $Inventory->inventory = $del_totalInv;
        $Inventory->save();
      }*/
      $del_inventory = CommercialInvoiceInventory::where('commercial_invoice_id','=',$id);
      $del_inventory->delete();

      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        $CommercialInventory = CommercialInvoiceInventory::create(array(
          'commercial_invoice_id' => $id,
          'inventory_id' => $request->item_id[$i],
          'quantity' => $request->quantity[$i],
          'unit_price' => $request->unit_price[$i],
          'total' => $request->total[$i],
          'description' => $request->description[$i],
          'weight' => $request->weight[$i],
        ));
        /*
        $Inventory = Inventory::find($request->item_id[$i]);
        //add to inventory to item
        $totalInv = $Inventory->inventory-$request->quantity[$i];
        //update
        $Inventory->inventory = $totalInv;
        $Inventory->save();
        */
      }

      return redirect('/shippment/commercial/create')->with('message', 'Success!');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $commercial_records = CommercialInvoice::where('id','=',$id)->delete();

      $del_inventory_records = CommercialInvoiceInventory::where('commercial_invoice_id','=',$id)->get();

      foreach ($del_inventory_records as $del) {
        //echo $del->inventory_id;
        $Inventory = Inventory::find($del->inventory_id);
        //add to inventory to item
        $del_totalInv = $Inventory->inventory+$del->quantity;
        //update
        $Inventory->inventory = $del_totalInv;
        $Inventory->save();
      }
      $del_inventory_records = CommercialInvoiceInventory::where('commercial_invoice_id','=',$id);
      $del_inventory_records->delete();

      return redirect('/shippment/commercial/create')->with('message', 'Deleted!');

    }
}
