<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;
use App\Supplier;
use App\Inventory;
use App\MyCompany;
use App\InventoryKit;
use App\CommercialInvoice;
use App\ProformaInvoice;
use App\ProformaInvoiceInventory;

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

    public function InformationIndex(){
      $inventory = Inventory::distinct()->orderby('id','asc')->get();
      $customer = Customer::distinct()->orderby('id','asc')->get();
      $supplier = Supplier::distinct()->orderby('id','asc')->get();
      return view('information/index')->with('inventory',$inventory)
        ->with('customer',$customer)->with('supplier',$supplier);
    }

    public function InformationExport(Request $request,$type){
      switch ($type) {
        case 'customer':
        $information = Customer::whereIn('id', $request->customer)->get();
          break;

        case 'inventory':
        $information = Inventory::whereIn('id', $request->inventory)->get();
          break;

        case 'supplier':
        $information = Supplier::whereIn('id', $request->supplier)->get();
          break;

        default:
          # code...
          break;
      }
      $mycompany = MyCompany::firstOrNew(['id' => '1']);

      return view('information/show')
        ->with('type',$type)->with('information',$information)->with('mycompany',$mycompany);
    }

}