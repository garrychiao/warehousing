<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseInventoryRecord extends Model
{
    protected $fillable = array('purchase_records_id','inventory_id','quantity','unit_price','total','remark');

    public function Purchase_Record()
    {
      return $this->belongsTo('App\PurchaseRecord', 'purchase_records_id');
    }

}
