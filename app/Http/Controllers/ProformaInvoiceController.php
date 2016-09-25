<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProformaInvoice;
use App\ProformaInvoiceInventory;
use App\CommercialInvoice;
use App\CommercialInvoiceInventory;
use App\Inventory;
use App\Customer;
use App\MyCompany;
use App\InventoryKit;
use App\InventoryKitMember;
use App\Http\Requests\ProformaInvoiceRequest;
use DB;

class ProformaInvoiceController extends Controller
{
  public function __construct()
  {
    $this->middleware('emp_rights:proforma');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','inventory','unit_weight','price1','price2','price3','price4','price5','price6','id')->orderBy('id', 'asc')->get();
       $inventory_kits = InventoryKit::distinct()->get();
       $customer = Customer::distinct()->orderBy('id','asc')->get();
       $idcount = ProformaInvoice::select('created_at')->whereDate('created_at','=',date("Y-m-d"))->count()+1;
       return view('shippment/proforma/index')->with('inventory',$inventory)->with('inventory_kits',$inventory_kits)
              ->with('customer',$customer)->with('form_id',$idcount);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $records = ProformaInvoice::leftjoin('customers','customers.id','=','proforma_invoices.customer_id')
          ->select('proforma_invoices.*','customers.chi_name','customers.contact_person')
          ->addSelect(DB::raw("(SELECT sum(total) from proforma_invoice_inventories WHERE proforma_invoice_inventories.proforma_invoice_id = proforma_invoices.id) as amount"))
          ->addSelect(DB::raw("(SELECT CASE WHEN due_date >= '".date("Y-m-d")."' THEN false ELSE true END) as overdue"))
          ->orderby('proforma_invoices.id')->paginate(10);

      $id = array();
      foreach($records as $rec){
        array_push($id,$rec->id);
      }
      $inv_records = ProformaInvoiceInventory::leftjoin('inventories','proforma_invoice_inventories.inventory_id','=','inventories.id')
      ->leftjoin('inventory_kits','proforma_invoice_inventories.kits_id','=','inventory_kits.id')
      ->whereIn('proforma_invoice_inventories.proforma_invoice_id', $id)->get();

      return view('/shippment/proforma/records')->with('records',$records)->with('inv_records',$inv_records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProformaInvoiceRequest $request)
    {
      $proforma = ProformaInvoice::create(
      array('customer_id' => $request->customer_id,
            'order_id' => $request->order_id,
            'create_date' => $request->create_date,
            'bill_to' => $request->bill_to,
            'ship_to' => $request->ship_to,
            'POnumber' => $request->POnumber,
            'payment_terms' => $request->payment_terms,
            'rep' => $request->rep,
            'ship' => $request->ship,
            'via' => $request->via,
            'FOB' => $request->FOB,
            'sandh' => $request->sandh,
            'converted' => false,
            'due_date' => $request->due_date
          ));
      $recordID = ProformaInvoice::select('id')->where('order_id','=',$request->order_id)->first();
      //the inventory amount part
      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        //$check_is_kit = strstr($request->item_id[$i],'K',true);
        if(strpos($request->item_id[$i],"K")){
          $kits_id = strstr($request->item_id[$i],'K',true);
          $PurchaseInventory = ProformaInvoiceInventory::create(array(
            'inventory_id' => null,
            'kits_id'=> $kits_id,
            'proforma_invoice_id' => $recordID->id,
            'quantity' => $request->quantity[$i],
            'unit_price' => $request->unit_price[$i],
            'total' => $request->total[$i],
            'weight' => $request->weight[$i],
            'description' => $request->description[$i],
          ));
        }else{
          $PurchaseInventory = ProformaInvoiceInventory::create(array(
            'inventory_id' => $request->item_id[$i],
            'kits_id'=> null,
            'proforma_invoice_id' => $recordID->id,
            'quantity' => $request->quantity[$i],
            'unit_price' => $request->unit_price[$i],
            'total' => $request->total[$i],
            'weight' => $request->weight[$i],
            'description' => $request->description[$i],
          ));
        }
        /*
        $Inventory = Inventory::find($request->item_id[$i]);
        //update to preserved quantity
        $Inventory->preserved_inv += $request->quantity[$i];
        $Inventory->save();*/
      }

      return redirect('/shippment/proforma/create')->with('message', 'Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory_kits_records = ProformaInvoiceInventory::join('inventory_kits','inventory_kits.id','=','proforma_invoice_inventories.kits_id')
              ->select('proforma_invoice_inventories.*','inventory_kits.kits_name','inventory_kits.kits_id as item_id','inventory_kits.kits_description')
              ->whereNotNull('proforma_invoice_inventories.kits_id')->where('proforma_invoice_id','=',$id)->get();
        $mycompany = MyCompany::firstOrNew(['id' => '1']);
        $records = ProformaInvoice::findOrFail($id);
        $inventory = ProformaInvoiceInventory::join('inventories','inventories.id','=','proforma_invoice_inventories.inventory_id')
        ->select('proforma_invoice_inventories.*','inventories.item_id','inventories.descriptions')
        ->where('proforma_invoice_id', $id)->get();
        $total_inv = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id)->sum('total');
        $total = $total_inv + $records->sandh;
        return view('/shippment/proforma/show')->with('records',$records)
        ->with('total',$total)->with('inventory_kits_records',$inventory_kits_records)
        ->with('inventory',$inventory)->with('mycompany',$mycompany);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $inventory_kits = InventoryKit::distinct()->get();
      $inventory_kits_records = ProformaInvoiceInventory::join('inventory_kits','inventory_kits.id','=','proforma_invoice_inventories.kits_id')
              ->select('proforma_invoice_inventories.*','inventory_kits.kits_name')
              ->whereNotNull('proforma_invoice_inventories.kits_id')->where('proforma_invoice_id','=',$id)->get();
      $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','unit_weight','inventory','price1','price2','price3','price4','price5','price6','id')->orderBy('id', 'asc')->get();
      $customer = Customer::distinct()->orderBy('id','asc')->get();
      $records = ProformaInvoice::findOrFail($id);
      $rec_inventory = ProformaInvoiceInventory::join('inventories','inventories.id','=','proforma_invoice_inventories.inventory_id')
      ->select('proforma_invoice_inventories.*','inventories.item_id','inventories.item_name','inventories.descriptions')
      ->where('proforma_invoice_id', $id)->get();
      $total = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id)->sum('total');

      return view('shippment/proforma/edit')->with('inventory',$inventory)->with('customer',$customer)
              ->with('records',$records)->with('rec_inventory',$rec_inventory)
              ->with('inventory_kits',$inventory_kits)->with('inventory_kits_records',$inventory_kits_records)
              ->with('total',$total);
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

      $proforma_records = ProformaInvoice::find($id);

      $proforma_records->update([
              'customer_id' => $request->customer_id,
              'order_id' => $request->order_id,
              'create_date' => $request->create_date,
              'bill_to' => $request->bill_to,
              'ship_to' => $request->ship_to,
              'POnumber' => $request->POnumber,
              'payment_terms' => $request->payment_terms,
              'rep' => $request->rep,
              'ship' => $request->ship,
              'via' => $request->via,
              'FOB' => $request->FOB,
              'sandh' => $request->sandh,
              'due_date' => $request->due_date
      ]);
      $del_inventory = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id);
      $del_inventory->delete();

      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        //$check_is_kit = strstr($request->item_id[$i],'K',true);
        if(strpos($request->item_id[$i],"K")){
          $kits_id = strstr($request->item_id[$i],'K',true);
          $PurchaseInventory = ProformaInvoiceInventory::create(array(
            'inventory_id' => null,
            'kits_id'=> $kits_id,
            'proforma_invoice_id' => $id,
            'quantity' => $request->quantity[$i],
            'unit_price' => $request->unit_price[$i],
            'total' => $request->total[$i],
            'weight' => $request->weight[$i],
            'description' => $request->description[$i],
          ));
        }else{
          $PurchaseInventory = ProformaInvoiceInventory::create(array(
            'inventory_id' => $request->item_id[$i],
            'kits_id'=> null,
            'proforma_invoice_id' => $id,
            'quantity' => $request->quantity[$i],
            'unit_price' => $request->unit_price[$i],
            'total' => $request->total[$i],
            'weight' => $request->weight[$i],
            'description' => $request->description[$i],
          ));
        }
      }
      if($proforma_records->converted == true){
        echo "has converted";
        $commercial_records = CommercialInvoice::where('reference','=',$request->order_id)->get();

        $del_inventory_records = CommercialInvoiceInventory::where('commercial_invoice_id','=',$commercial_records->id)->get();

        foreach ($del_inventory_records as $del) {
          //echo $del->inventory_id;
          $Inventory = Inventory::find($del->inventory_id);
          //add to inventory to item
          $del_totalInv = $Inventory->inventory+$del->quantity;
          //update
          $Inventory->inventory = $del_totalInv;
          $Inventory->save();
        }
        $del_inventory_records = CommercialInvoiceInventory::where('commercial_invoice_id','=',$commercial_records->id);
        $del_inventory_records->delete();

        $commercial_records = CommercialInvoice::where('reference','=',$request->order_id)->delete();

        $proforma_records->converted = false;
        $proforma_records->save();
      }

      return redirect('/shippment/proforma/create')->with('message', 'Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $del_proforma_records = ProformaInvoice::where('id','=',$id)->delete();
      $del_inventory_records = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id);
      $del_inventory_records->delete();

      return redirect('/shippment/proforma/create')->with('message', 'Deleted!');

    }
}
