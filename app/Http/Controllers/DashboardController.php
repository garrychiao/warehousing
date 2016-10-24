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

class DashboardController extends Controller
{
    public function welcome(){
      $pur_records = PurchaseRecord::where('delivery_date','>',date('Y-m-d')-30)->get();
      $com_records = CommercialInvoice::where('export_date','>',date('Y-m-d')-30)->get();
      $id = array();
      foreach($pur_records as $rec){
        array_push($id,$rec->id);
      }
      $pur_inv_records = PurchaseInventoryRecord::join('inventories','purchase_inventory_records.inventory_id','=','inventories.id')
          ->whereIn('purchase_records_id', $id)->get();
      $id = array();
      foreach($com_records as $rec){
        array_push($id,$rec->id);
      }
      $com_inv_records = CommercialInvoiceInventory::leftjoin('inventories','commercial_invoice_inventories.inventory_id','=','inventories.id')
          ->leftjoin('inventory_kits','commercial_invoice_inventories.kits_id','=','inventory_kits.id')
          ->whereIn('commercial_invoice_inventories.commercial_invoice_id', $id)->get();
      return view('welcome')->with('pur_records',$pur_records)->with('com_records',$com_records)
                            ->with('pur_inv_records',$pur_inv_records)->with('com_inv_records',$com_inv_records);
    }
    public function convert($id)
    {
      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      $inventory = Inventory::distinct()->select('item_id','item_name','descriptions','inventory','unit_weight','price1','price2','price3','price4','price5','price6','id')->orderBy('display_order', 'asc')->get();
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
      $inv = Inventory::select('id')->orderby('id')->get();
      foreach($inv as $key => $i){
        DB::table('inventories')
            ->where('id', $i->id)
            ->update(['display_order' => $key]);
      }
    }
}
