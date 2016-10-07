<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;
use App\Supplier;
use App\Inventory;
use App\MyCompany;
use App\InventoryKit;
use App\PurchaseRecord;
use App\PurchaseInventoryRecord;
use App\CommercialInvoice;
use App\CommercialInvoiceInventory;
use App\ProformaInvoice;
use App\ProformaInvoiceInventory;
use DB;
use Mail;
use Excel;
use PDF;

class DashboardController extends Controller
{
    public function welcome(){
      $data_inv = Inventory::distinct()->select('item_id as letter','shipped_inv as frequency')->where('shipped_inv','>',0)->take(10)->orderBy('id', 'asc')->get();
      return view('welcome')->with('data_inv',$data_inv);
    }
    public function convert($id)
    {
      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','inventory','unit_weight','price1','price2','price3','price4','price5','price6','id')->orderBy('id', 'asc')->get();
      //kits
      $inventory_kits = InventoryKit::distinct()->get();
      $inventory_kits_records = ProformaInvoiceInventory::join('inventory_kits','inventory_kits.id','=','proforma_invoice_inventories.kits_id')
              ->select('proforma_invoice_inventories.*','inventory_kits.kits_name')
              ->whereNotNull('proforma_invoice_inventories.kits_id')->where('proforma_invoice_id','=',$id)->get();

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
        ->with('inventory_kits',$inventory_kits)->with('inventory_kits_records',$inventory_kits_records)
        ->with('total',$total)->with('rec_customer',$rec_customer)->with('final_total',$final_total);
    }

    public function test(){
      Excel::create('New file', function($excel) {

        $excel->sheet('New sheet', function($sheet) {

          $sheet->loadView('information.show');

        });

      });
    }
}
