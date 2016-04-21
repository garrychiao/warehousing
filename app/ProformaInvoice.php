<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaInvoice extends Model
{
  protected $fillable = array('customer_id','order_id','create_date','due_date','bill_to','ship_to','POnumber','payment_terms','rep','ship','via','FOB');

  public function PurchaseInventoryRecord()
  {
    return $this->hasMany('App\ProformaInvoiceInventory');
  }
}
