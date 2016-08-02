<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceInventory extends Model
{
  protected $fillable = array('proforma_invoice_id','inventory_id','kits_id','quantity','unit_price','weight','total','description');

  public function PurchaseInventoryRecord()
  {
    return $this->hasMany('App\ProformaInvoiceInventory');
  }
}
