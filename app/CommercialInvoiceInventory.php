<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommercialInvoiceInventory extends Model
{
  protected $fillable = array('commercial_invoice_id','inventory_id','kits_id','item_code','quantity','unit_price','total','description','weight');
}
