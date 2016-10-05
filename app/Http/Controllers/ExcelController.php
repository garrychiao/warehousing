<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Excel;
use App\Customer;
use App\Supplier;
use App\Inventory;
use App\MyCompany;
use App\InventoryKit;
use App\PurchaseRecord;
use App\PurchaseInventoryRecord;
use App\ProformaInvoice;
use App\ProformaInvoiceInventory;
use App\CommercialInvoice;
use App\CommercialInvoiceInventory;
use DB;

class ExcelController extends Controller
{
    //for information basic customer, inventory and supplier
    public function exportExcel(Request $request){
      $type = $request->export_type;
      switch ($type) {
        case 'customer':
        $FileName = "CustomerInfo";
        $information = Customer::select('customer_id as ID','chi_name as Name(Chi)','eng_name as Name(Eng)','owner as Owner','contact_person as Contact','email','phone','fax','nationality','notify_address')
          ->whereIn('id', $request->item_id)->get();
          break;

        case 'inventory':
        $FileName = "ProductInfo";
        $information = Inventory::select('item_id as ItemID','category','item_name as ItemName','descriptions','unit_weight as UnitWeight','price1 as SamplePrice','price2 as 21~100','price3 as 101~300','price4 as 301~500','price5 as 501~1000','price6 as 1000~')
        ->whereIn('id', $request->item_id)->get();
          break;

        case 'supplier':
        $FileName = "SupplierInfo";
        $information = Supplier::select('supplier_id as ID','supplier_name as Name','owner as Owner','phone','fax','email','address')
        ->whereIn('id', $request->item_id)->get();
          break;

        default:
          # code...
          break;
      }

      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      Excel::create($FileName, function($excel) use($information,$FileName,$mycompany) {

        $excel->sheet('Sheetname', function($sheet) use($information,$FileName,$mycompany) {
          $sheet->mergeCells('A1:H1');
          $sheet->mergeCells('A2:D4');
          $sheet->mergeCells('E2:H2');
          $sheet->mergeCells('E3:H3');
          $sheet->mergeCells('E4:H4');
          $sheet->cell('A1', function($cell) use($mycompany){
            $cell->setValue($mycompany->eng_name);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '24',
              'bold'       =>  true
            ));
          });
          $sheet->cell('A2', function($cell) use($FileName){
            $cell->setValue($FileName);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '22',
              'bold'       =>  true
            ));
          });
          $sheet->cell('E2', function($cell) use($mycompany){

            $cell->setValue($mycompany->eng_address);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '16',
              'bold'       =>  true
            ));
          });
          $sheet->cell('E3', function($cell) use($mycompany){

            $cell->setValue($mycompany->email);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '16',
              'bold'       =>  true
            ));
          });
          $sheet->cell('E4', function($cell) use($mycompany){

            $cell->setValue($mycompany->phone);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '16',
              'bold'       =>  true
            ));
          });
          $sheet->fromArray($information,null,'A5');

        });

      })->export('xls');
    }
    // for information output invoices
    public function exportExcel_invoice(Request $request){
      $type = $request->export_type;
      switch ($type) {
        case 'invoices_purchase':
          $FileName = "Purchased ".date("Ymd", strtotime($request->start_date))."~".date("Ymd", strtotime($request->end_date));
          $information = PurchaseRecord::join('suppliers','suppliers.id','=','purchase_records.supplier_id')
              ->select('purchase_records.*','suppliers.supplier_name')
              ->addSelect(DB::raw("(SELECT sum(total) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as amount"))
              //->addSelect(DB::raw("(SELECT count(total) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as count"))
              ->whereIn('purchase_records.id',$request->item_id)->get();
          $id = array();
          foreach($information as $inf){
            array_push($id,$inf->id);
          }
          $invoice_records = PurchaseInventoryRecord::join('inventories','purchase_inventory_records.inventory_id','=','inventories.id')
          ->whereIn('purchase_records_id', $id)->get();
          break;

        case 'invoices_proforma':
          $FileName = "Proforma ".date("Ymd", strtotime($request->start_date))."~".date("Ymd", strtotime($request->end_date));
          $information = ProformaInvoice::join('customers','customers.id','=','proforma_invoices.customer_id')
              ->select('proforma_invoices.*','customers.eng_name')
              ->addSelect(DB::raw("(SELECT sum(total) from proforma_invoice_inventories WHERE proforma_invoice_inventories.proforma_invoice_id = proforma_invoices.id) as amount"))
              //->addSelect(DB::raw("(SELECT count(total) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as count"))
              ->whereIn('proforma_invoices.id',$request->item_id)->get();
          $id = array();
          foreach($information as $inf){
            array_push($id,$inf->id);
          }
          $invoice_records = ProformaInvoiceInventory::leftjoin('inventories','proforma_invoice_inventories.inventory_id','=','inventories.id')
              ->leftjoin('inventory_kits','proforma_invoice_inventories.kits_id','=','inventory_kits.id')
              ->whereIn('proforma_invoice_id', $id)->get();
          break;

        case 'invoices_commercial':
          $FileName = "Commercial ".date("Ymd", strtotime($request->start_date))."~".date("Ymd", strtotime($request->end_date));
          $information = CommercialInvoice::join('customers','customers.id','=','commercial_invoices.customer_id')
              ->select('commercial_invoices.*','customers.eng_name')
              ->addSelect(DB::raw("(SELECT sum(total) from commercial_invoice_inventories WHERE commercial_invoice_inventories.commercial_invoice_id = commercial_invoices.id) as amount"))
              //->addSelect(DB::raw("(SELECT count(total) from purchase_inventory_records WHERE purchase_inventory_records.purchase_records_id = purchase_records.id) as count"))
              ->whereIn('commercial_invoices.id',$request->item_id)->get();
          $id = array();
          foreach($information as $inf){
            array_push($id,$inf->id);
          }
          $invoice_records = CommercialInvoiceInventory::leftjoin('inventories','commercial_invoice_inventories.inventory_id','=','inventories.id')
              ->leftjoin('inventory_kits','commercial_invoice_inventories.kits_id','=','inventory_kits.id')
              ->whereIn('commercial_invoice_id', $id)->get();
          break;

        default:
          # code...
          break;
      }
      $mycompany = MyCompany::firstOrNew(['id' => '1']);
/*
      return view('information.excel')
      ->with('type',$type)->with('information',$information)
      ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
*/
      Excel::create($FileName, function($excel) use($information,$FileName,$mycompany,$invoice_records,$type) {

        $excel->sheet('Sheetname', function($sheet) use($information,$FileName,$mycompany,$invoice_records,$type) {

          switch($type){
            case 'invoices_purchase':
            $sheet->loadView('information.excel')
                  ->with('type',$type)->with('information',$information)
                  ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
              break;

            case 'invoices_proforma':
              $sheet->loadView('information.excel')
                    ->with('type',$type)->with('information',$information)
                    ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
              break;

            case 'invoices_commercial':
              $sheet->loadView('information.excel')
                    ->with('type',$type)->with('information',$information)
                    ->with('mycompany',$mycompany)->with('invoice_records',$invoice_records);
              break;

            default:
              # code...
              break;
          }
        });

      })->export('xls');
    }
    //for shown records
    public function exportExcel_record($invoice, $id){

      $mycompany = MyCompany::firstOrNew(['id' => '1']);

      switch($invoice){
        //purchase records
        case 'purchase':
          //get basic records
          $records = PurchaseRecord::join('suppliers','suppliers.id','=','purchase_records.supplier_id')
          ->select('purchase_records.*','suppliers.supplier_name')
          ->where('purchase_records.id','=',$id)->get();
          //get each inventory records
          $inventory = PurchaseInventoryRecord::join('inventories','inventories.id','=','purchase_inventory_records.inventory_id')
          ->select('purchase_inventory_records.*','inventories.item_id','inventories.item_name')
          ->where('purchase_records_id','=',$id)->get();
          //set kits null
          $inventory_kits_records = null;
          //data passed to purchase/excel.blade.php which copied from purchase/show.blade.php
          $total = PurchaseInventoryRecord::where('purchase_records_id','=',$id)->sum('total');
          //customer/supplier name + order id
          $FileName = $records[0]->supplier_name."_".$records[0]->order_id;
          break;
        //proforma invoice records
        case 'proforma':
          //get basic records
          $records = ProformaInvoice::join('customers','customers.id','=','proforma_invoices.customer_id')
          ->select('proforma_invoices.*','customers.eng_name')
          ->where('proforma_invoices.id','=',$id)->get();
          //get each inventory records
          $inventory = ProformaInvoiceInventory::join('inventories','inventories.id','=','proforma_invoice_inventories.inventory_id')
          ->select('proforma_invoice_inventories.*','inventories.item_id','inventories.item_name')
          ->where('proforma_invoice_id','=',$id)->get();
          //get inventory kits
          $inventory_kits_records = ProformaInvoiceInventory::join('inventory_kits','inventory_kits.id','=','proforma_invoice_inventories.kits_id')
          ->select('proforma_invoice_inventories.*','inventory_kits.kits_name','inventory_kits.kits_id as item_id','inventory_kits.kits_description')
          ->whereNotNull('proforma_invoice_inventories.kits_id')->where('proforma_invoice_id','=',$id)->get();
          //data passed to purchase/excel.blade.php which copied from purchase/show.blade.php
          $total_inv = ProformaInvoiceInventory::where('proforma_invoice_id','=',$id)->sum('total');
          $total = $total_inv + $records->sandh;
          //customer/supplier name + order id
          $FileName = $records[0]->eng_name."_".$records[0]->order_id;
          break;

        case 'commercial':
          //get basic records
          $records = CommercialInvoice::join('customers','customers.id','=','commercial_invoices.customer_id')
          ->select('commercial_invoices.*','customers.eng_name')
          ->where('commercial_invoices.id','=',$id)->get();
          //get each inventory records
          $inventory = CommercialInvoiceInventory::join('inventories','inventories.id','=','commercial_invoice_inventories.inventory_id')
          ->select('commercial_invoice_inventories.*','inventories.item_id','inventories.item_name')
          ->where('commercial_invoice_id','=',$id)->get();
          //get inventory kits
          $inventory_kits_records = CommercialInvoiceInventory::join('inventory_kits','inventory_kits.id','=','commercial_invoice_inventories.kits_id')
          ->select('commercial_invoice_inventories.*','inventory_kits.kits_name','inventory_kits.kits_id as item_id','inventory_kits.kits_description')
          ->whereNotNull('commercial_invoice_inventories.kits_id')->where('commercial_invoice_id','=',$id)->get();
          //data passed to purchase/excel.blade.php which copied from purchase/show.blade.php
          $total = CommercialInvoiceInventory::select(DB::raw('SUM(total) as total'),DB::raw('SUM(weight) as weight'),DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(unit_price) as unit_price'))
          ->where('commercial_invoice_id','=',$id)->first();

          $FileName = $records[0]->eng_name."_".$records[0]->order_id;
          break;

        default:
          # code...
          break;
      }

      Excel::create($FileName, function($excel) use($FileName,$invoice,$mycompany,$records,$inventory,$total,$inventory_kits_records) {

        $excel->sheet('Sheetname', function($sheet) use($FileName,$invoice,$mycompany,$records,$inventory,$total,$inventory_kits_records) {

          switch($invoice){
            case 'purchase':
            $sheet->loadView('purchase.excel')->with('records',$records)->with('inventory',$inventory)
                ->with('mycompany',$mycompany)->with('total',$total);
              break;

            case 'proforma':
            $sheet->loadView('shippment.proforma.excel')->with('records',$records)->with('inventory',$inventory)
                ->with('mycompany',$mycompany)->with('total',$total)->with('inventory_kits_records',$inventory_kits_records);
              break;

            case 'commercial':
            $sheet->loadView('shippment.commercial.excel')->with('records',$records)->with('inventory',$inventory)
                ->with('mycompany',$mycompany)->with('total',$total)
                ->with('inventory_kits_records',$inventory_kits_records);
              break;

            default:
              # code...
              break;
          }

        });

      })->export('xls');

    }
    /*
    public function exportPDF(Request $request){
      $type = $request->export_type;
      switch ($type) {
        case 'customer':
        $FileName = "CustomerInfo";
        $information = Customer::whereIn('id', $request->item_id)->get();
          break;

        case 'inventory':
        $FileName = "ProductInfo";
        $information = Inventory::select('item_id as ItemID','category','item_name as ItemName','descriptions','unit_weight as UnitWeight','price1 as SamplePrice','price2 as 21~100','price3 as 101~300','price4 as 301~500','price5 as 501~1000','price6 as 1000~')
        ->whereIn('id', $request->item_id)->get();
          break;

        case 'supplier':
        $FileName = "SupplierInfo";
        $information = Supplier::whereIn('id', $request->item_id)->get();
          break;

        default:
          # code...
          break;
      }

      $mycompany = MyCompany::firstOrNew(['id' => '1']);
      Excel::create($FileName, function($excel) use($information,$FileName,$mycompany) {

        $excel->sheet('Sheetname', function($sheet) use($information,$FileName,$mycompany) {
          $sheet->mergeCells('A1:H1');
          $sheet->mergeCells('A2:D4');
          $sheet->mergeCells('E2:H2');
          $sheet->mergeCells('E3:H3');
          $sheet->mergeCells('E4:H4');
          $sheet->cell('A1', function($cell) use($mycompany){
            $cell->setValue($mycompany->eng_name);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '24',
              'bold'       =>  true
            ));
          });
          $sheet->cell('A2', function($cell) use($FileName){
            $cell->setValue($FileName);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '22',
              'bold'       =>  true
            ));
          });
          $sheet->cell('E2', function($cell) use($mycompany){

            $cell->setValue($mycompany->eng_address);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '16',
              'bold'       =>  true
            ));
          });
          $sheet->cell('E3', function($cell) use($mycompany){

            $cell->setValue($mycompany->email);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '16',
              'bold'       =>  true
            ));
          });
          $sheet->cell('E4', function($cell) use($mycompany){

            $cell->setValue($mycompany->phone);
            // Set font
            $cell->setFont(array(
              'family'     => 'Calibri',
              'size'       => '16',
              'bold'       =>  true
            ));
          });
          $sheet->fromArray($information,null,'A5');
          //$sheet->prependRow(array(
          //  'prepended', 'prepended'
          //));
        });

      })->export('pdf');
    }*/
}
