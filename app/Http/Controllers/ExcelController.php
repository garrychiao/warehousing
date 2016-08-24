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

class ExcelController extends Controller
{
    public function exportExcel(Request $request){
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
