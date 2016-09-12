<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRecord extends Model
{
    protected $fillable = array('supplier_id','order_id','purchase_date','delivery_date','payment_terms','delivery_address','packing','shipping_sample','undertaker','precautions');

    public function PurchaseInventoryRecord()
    {
      return $this->hasMany('App\PurchaseInventoryRecord');
    }
}
