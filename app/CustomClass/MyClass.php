<?php

namespace App\CustomClass;

use App\ProformaInvoice;
use App\ProformaInvoiceInventory;
use App\CommercialInvoiceInventory;
use App\CommercialInvoice;
use App\InventoryKitMember;
use App\Inventory;
use DB;

class MyClass
{
  public static function setInventory(){
    $lists = Inventory::select('id',
              DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from proforma_invoice_inventories a1 join proforma_invoices a2 on a1.proforma_invoice_id = a2.id WHERE a1.inventory_id = inventories.id and a2.due_date >= '".date('Y-m-d')."' and a2.converted = false and a1.inventory_id IS NOT NULL) as preserved_inventory"),
              DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from commercial_invoice_inventories a1 join commercial_invoices a2 on a1.commercial_invoice_id = a2.id WHERE a1.inventory_id = inventories.id and a1.inventory_id IS NOT NULL) as shipped_inventory"),
              DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from purchase_inventory_records a1 join purchase_records a2 on a1.purchase_records_id = a2.id WHERE a1.inventory_id = inventories.id and a2.delivery_date > '".date('Y-m-d')."' and a1.inventory_id IS NOT NULL) as incoming_inv"),
              DB::raw("(SELECT CASE WHEN sum(a1.quantity) IS NULL THEN 0 ELSE sum(a1.quantity) END from purchase_inventory_records a1 join purchase_records a2 on a1.purchase_records_id = a2.id WHERE a1.inventory_id = inventories.id and a2.delivery_date <='".date('Y-m-d')."' and a1.inventory_id IS NOT NULL) as inventory"),
              DB::raw("(SELECT CASE WHEN sum(a1.total) IS NULL THEN 0 ELSE sum(a1.total) END from purchase_inventory_records a1 join purchase_records a2 on a1.purchase_records_id = a2.id WHERE a1.inventory_id = inventories.id and a2.delivery_date <='".date('Y-m-d')."' and a1.inventory_id IS NOT NULL) as total"))
              ->orderBy('id', 'asc')->get();
    //Update invenotry datas
    foreach($lists as $list){
      $avg_cost = 0;
      if($list->inventory != 0){
        $avg_cost = $list->total/$list->inventory;
      }
      DB::table('inventories')
            ->where('id','=',$list->id)
            ->update(['preserved_inv' => $list->preserved_inventory,
                      'incoming_inv' => $list->incoming_inv,
                      'inventory' => $list->inventory-$list->shipped_inventory,
                      'avg_cost' => $avg_cost,
                      'shipped_inv' => $list->shipped_inventory]);
    }
    //select proforma inventory "kits" part and add to the above before due_date for each item
    $lists_proforma_kits = ProformaInvoiceInventory::select('kits_id','quantity')->join('proforma_invoices', 'proforma_invoices.id', '=', 'proforma_invoice_inventories.proforma_invoice_id')
              ->where('due_date','>=',date('Y-m-d'))->where('converted','=',false)->whereNotNull('kits_id')->get();
    //select each commercial inventory "kits" part to substract to the purchased
    $lists_commercial_kits = CommercialInvoiceInventory::select('kits_id','quantity')->join('commercial_invoices', 'commercial_invoices.id', '=', 'commercial_invoice_inventories.commercial_invoice_id')
              ->whereNotNull('kits_id')->get();

    foreach ($lists_proforma_kits as $p_kits) {
      $find_kits = InventoryKitMember::select('inventory_id','inventory_name','quantity')->where('kits_id','=',$p_kits->kits_id)->get();
      foreach ($find_kits as $find) {
        DB::table('inventories')
              ->where('id','=',$find->inventory_id)
              ->increment('preserved_inv', $find->quantity*$p_kits->quantity);
      }
    }
    foreach ($lists_commercial_kits as $c_kits) {
      $find_kits = InventoryKitMember::select('inventory_id','inventory_name','quantity')->where('kits_id','=',$c_kits->kits_id)->get();
      foreach ($find_kits as $find) {
        DB::table('inventories')
              ->where('id','=',$find->inventory_id)
              ->increment('shipped_inv', $find->quantity*$c_kits->quantity);
        DB::table('inventories')
              ->where('id','=',$find->inventory_id)
              ->decrement('inventory', $find->quantity*$c_kits->quantity);
      }
    }
  }
}
