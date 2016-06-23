<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;
use App\Inventory;
use App\MyCompany;
use App\CommercialInvoice;
use App\ProformaInvoice;
use App\ProformaInvoiceInventory;

class DashboardController extends Controller
{
    public function convert($id)
    {
      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','inventory','price1','price2','price3','price4','price5','price6','id')->orderBy('id', 'asc')->get();
      $customer = Customer::distinct()->orderBy('id','asc')->get();
      $idcount = CommercialInvoice::select('created_at')->whereDate('created_at','=',date("Y-m-d"))->count()+1;
      $records = ProformaInvoice::findOrFail($id);
      $rec_customer = Customer::where('id','=',$records->customer_id)->first();
      $rec_inventory = ProformaInvoiceInventory::join('inventories','inventories.id','=','proforma_invoice_inventories.inventory_id')
      ->select('proforma_invoice_inventories.*','inventories.item_id','inventories.item_name','inventories.descriptions')
      ->where('proforma_invoice_id', $id)->get();
      $total = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id)->sum('total');
      $final_total = $records->sandh+$total;

      return view('convert/convert')->with('inventory',$inventory)
        ->with('customer',$customer)->with('form_id',$idcount)->with('mycompany',$mycompany)
        ->with('records',$records)->with('rec_inventory',$rec_inventory)->with('proforma_id',$id)
        ->with('total',$total)->with('rec_customer',$rec_customer)->with('final_total',$final_total);
    }
}
