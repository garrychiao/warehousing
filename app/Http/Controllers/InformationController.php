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

class InformationController extends Controller
{
  public function InformationIndex(){
    $inventory = Inventory::distinct()->orderby('id','asc')->get();
    $customer = Customer::distinct()->orderby('id','asc')->get();
    $supplier = Supplier::distinct()->orderby('id','asc')->get();
    return view('information/index')->with('inventory',$inventory)
      ->with('customer',$customer)->with('supplier',$supplier);
  }

  public function InformationExport(Request $request,$type){

    $mycompany = MyCompany::firstOrNew(['id' => '1']);

    switch ($type) {
      case 'customer':
      $information = Customer::whereIn('id', $request->customer)->get();
      return view('information/show')
        ->with('type',$type)->with('information',$information)->with('mycompany',$mycompany);
        break;

      case 'inventory':
      $information = Inventory::whereIn('id', $request->inventory)->get();
      return view('information/show')
        ->with('type',$type)->with('information',$information)->with('mycompany',$mycompany);
        break;

      case 'supplier':
      $information = Supplier::whereIn('id', $request->supplier)->get();
      return view('information/show')
        ->with('type',$type)->with('information',$information)->with('mycompany',$mycompany);
        break;


      //invoices
      case 'invoices_purchase':
      if($request->supplier_id!=0){
        $information = PurchaseRecord::join('suppliers','suppliers.id','=','purchase_records.supplier_id')
            ->select('purchase_records.*','suppliers.supplier_name')
            ->addSelect(DB::raw("(SELECT sum(total) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as amount"))
            ->where('purchase_records.supplier_id','=',$request->supplier_id)
            ->whereBetween('purchase_date', [$request->start_date,$request->end_date])->get();
        //convert objects to array
        $id = array();
        foreach($information as $inf){
          array_push($id,$inf->id);
        }
        $invoice_records = PurchaseInventoryRecord::join('inventories','purchase_inventory_records.inventory_id','=','inventories.id')
        ->whereIn('purchase_records_id', $id)->get();

        return view('information/show_invoice')
          ->with('type',$type)->with('information',$information)
          ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
      }else{
        $information = PurchaseRecord::join('suppliers','suppliers.id','=','purchase_records.supplier_id')
            ->select('purchase_records.id','purchase_records.order_id','purchase_records.purchase_date','purchase_records.delivery_date','suppliers.supplier_name')
            ->addSelect(DB::raw("(SELECT sum(total) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as amount"))
            ->whereBetween('purchase_date', [$request->start_date,$request->end_date])->get();
        //convert objects to array
        $id = array();
        foreach($information as $inf){
          array_push($id,$inf->id);
        }
        $invoice_records = PurchaseInventoryRecord::join('inventories','purchase_inventory_records.inventory_id','=','inventories.id')
        ->whereIn('purchase_records_id', $id)->get();
        return view('information/show_invoice')
          ->with('type',$type)->with('information',$information)
          ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);

      }
        break;
      //
      case 'invoices_proforma':
        if($request->customer_id!=0){
          $information = ProformaInvoice::join('customers','customers.id','=','proforma_invoices.customer_id')
              ->select('proforma_invoices.*','customers.eng_name')
              ->addSelect(DB::raw("(SELECT sum(total) from proforma_invoice_inventories WHERE proforma_invoice_inventories.proforma_invoice_id = proforma_invoices.id) as amount"))
              ->where('proforma_invoices.customer_id','=',$request->customer_id)
              ->whereBetween('create_date', [$request->start_date,$request->end_date])->get();
          //convert objects to array
          $id = array();
          foreach($information as $inf){
            array_push($id,$inf->id);
          }
          $invoice_records = ProformaInvoiceInventory::leftjoin('inventories','proforma_invoice_inventories.inventory_id','=','inventories.id')
          ->leftjoin('inventory_kits','proforma_invoice_inventories.kits_id','=','inventory_kits.id')
          ->whereIn('proforma_invoice_id', $id)->get();

          return view('information/show_invoice')
            ->with('type',$type)->with('information',$information)
            ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
        }else{
          $information = ProformaInvoice::join('customers','customers.id','=','proforma_invoices.customer_id')
              ->select('proforma_invoices.*','customers.eng_name')
              ->addSelect(DB::raw("(SELECT sum(total) from proforma_invoice_inventories WHERE proforma_invoice_inventories.proforma_invoice_id = proforma_invoices.id) as amount"))
              ->whereBetween('create_date', [$request->start_date,$request->end_date])->get();
          //convert objects to array
          $id = array();
          foreach($information as $inf){
            array_push($id,$inf->id);
          }
          $invoice_records = ProformaInvoiceInventory::leftjoin('inventories','proforma_invoice_inventories.inventory_id','=','inventories.id')
          ->leftjoin('inventory_kits','proforma_invoice_inventories.kits_id','=','inventory_kits.id')
          ->whereIn('proforma_invoice_id', $id)->get();

          return view('information/show_invoice')
            ->with('type',$type)->with('information',$information)
            ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);

        }

        break;
      //
      case 'invoices_commercial':
        if($request->customer_id!=0){
          $information = Commercial::join('customers','customers.id','=','commercial_invoices.customer_id')
              ->select('commercial_invoices.*','customers.eng_name')
              ->addSelect(DB::raw("(SELECT sum(total) from commercial_invoice_inventories WHERE commercial_invoice_inventories.commercial_invoice_id = commercial_invoices.id) as amount"))
              ->where('commercial_invoices.customer_id','=',$request->customer_id)
              ->whereBetween('create_date', [$request->start_date,$request->end_date])->get();
          //convert objects to array
          $id = array();
          foreach($information as $inf){
            array_push($id,$inf->id);
          }
          $invoice_records = CommercialInvoiceInventory::leftjoin('inventories','commercial_invoice_inventories.inventory_id','=','inventories.id')
          ->leftjoin('inventory_kits','commercial_invoice_inventories.kits_id','=','inventory_kits.id')
          ->whereIn('commercial_invoice_id', $id)->get();

          return view('information/show_invoice')
            ->with('type',$type)->with('information',$information)
            ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
        }else{
          $information = CommercialInvoice::join('customers','customers.id','=','commercial_invoices.customer_id')
              ->select('commercial_invoices.*','customers.eng_name')
              ->addSelect(DB::raw("(SELECT sum(total) from commercial_invoice_inventories WHERE commercial_invoice_inventories.commercial_invoice_id = commercial_invoices.id) as amount"))
              ->whereBetween('create_date', [$request->start_date,$request->end_date])->get();
          //convert objects to array
          $id = array();
          foreach($information as $inf){
            array_push($id,$inf->id);
          }
          $invoice_records = CommercialInvoiceInventory::leftjoin('inventories','commercial_invoice_inventories.inventory_id','=','inventories.id')
          ->leftjoin('inventory_kits','commercial_invoice_inventories.kits_id','=','inventory_kits.id')
          ->whereIn('commercial_invoice_id', $id)->get();

          return view('information/show_invoice')
            ->with('type',$type)->with('information',$information)
            ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
        }
        break;

      default:
        # code...
        break;
    }

  }
}
