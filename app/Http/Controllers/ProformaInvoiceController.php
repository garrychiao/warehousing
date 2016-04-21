<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProformaInvoice;
use App\ProformaInvoiceInventory;
use App\Inventory;
use App\Customer;
use App\MyCompany;
use App\Http\Requests\ProformaInvoiceRequest;
use DB;

class ProformaInvoiceController extends Controller
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
       return view('shippment/proforma/index')->with('inventory',$inventory)->with('customer',$customer);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $records = ProformaInvoice::join('customers','customers.id','=','proforma_invoices.customer_id')
          ->select('proforma_invoices.*','customers.company_name','customers.contact_person')
          ->addSelect(DB::raw("(SELECT sum(total) from proforma_invoice_inventories WHERE proforma_invoice_inventories.proforma_invoice_id = proforma_invoices.id) as amount"))
          ->orderby('proforma_invoices.id')->get();
      return view('/shippment/proforma/records')->with('records',$records);
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
            'due_date' => $request->due_date
          ));
      $recordID = ProformaInvoice::select('id')->where('order_id','=',$request->order_id)->first();
      //the inventory amount part
      $length = count($request->item_id);
      for($i=0 ; $i<$length ; $i++){
        $PurchaseInventory = ProformaInvoiceInventory::create(array(
          'proforma_invoice_id' => $recordID->id,
          'inventory_id' => $request->item_id[$i],
          'quantity' => $request->quantity[$i],
          'unit_price' => $request->unit_price[$i],
          'total' => $request->total[$i],
          'description' => $request->description[$i],
        ));
      }

      return redirect('/shippment/proforma')->with('message', 'Success!');
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
        $records = ProformaInvoice::findOrFail($id);
        $inventory = ProformaInvoiceInventory::join('inventories','inventories.id','=','proforma_invoice_inventories.inventory_id')
        ->select('proforma_invoice_inventories.*','inventories.item_id','inventories.descriptions')
        ->where('proforma_invoice_id', $id)->get();
        $total = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id)->sum('total');
        $SandH = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id)->where('inventory_id','=','0')->first();

        return view('/shippment/proforma/show')->with('records',$records)
        ->with('total',$total)->with('SandH',$SandH)->with('mycompany_img',$mycompany_img)
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
