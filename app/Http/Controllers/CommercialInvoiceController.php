<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\Customer;
use App\MyCompany;
use DB;
use App\CommercialInvoice;
use App\CommercialInvoiceInventory;

class CommercialInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','inventory','price1','price2','price3','price4','price5','price6','id')->orderBy('id', 'asc')->get();
      $customer = Customer::distinct()->select('id','customer_id','company_name','contact_person','phone','recieve_zip_code','recieve_address')->orderBy('id','asc')->get();
      return view('shippment/commercial/index')->with('inventory',$inventory)->with('customer',$customer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $records = CommercialInvoice::join('customers','customers.id','=','commercial_invoices.customer_id')
          ->select('commercial_invoices.*','customers.company_name','customers.contact_person')
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
      //the inventory amount part
      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        $CommercialInventory = CommercialInvoiceInventory::create(array(
          'commercial_invoice_id' => $recordID->id,
          'inventory_id' => $request->item_id[$i],
          'quantity' => $request->quantity[$i],
          'unit_price' => $request->unit_price[$i],
          'total' => $request->total[$i],
          'description' => $request->description[$i],
          'weight' => $request->weight[$i],
        ));

        $Inventory = Inventory::find($request->item_id[$i]);
        //add to inventory to item
        $totalInv = $Inventory->inventory-$request->quantity[$i];
        //update
        $Inventory->inventory = $totalInv;
        $Inventory->save();
      }

      return redirect('/shippment/commercial')->with('message', 'Success!');
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
      $total = CommercialInvoiceInventory::select(DB::raw('SUM(total) as total'),DB::raw('SUM(weight) as weight'),DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(unit_price) as unit_price'))
      ->where('commercial_invoice_id','=',$id)->first();
      $final_total = $records->cost_shipping+$records->cost_insurance+$records->cost_additional+$total->total;

      return view('/shippment/commercial/show')->with('records',$records)
      ->with('total',$total)->with('inventory',$inventory)->with('mycompany_img',$mycompany_img)
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
        //
    }
}
