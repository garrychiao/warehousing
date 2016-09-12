<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommercialInvoice extends Model
{
  protected $fillable = array('create_date','order_id','export_date','terms_of_sale','reference','currency','customer_id','exporter','manufacture_country','consignee','notify_party','destination_country','airwaybill_number','packages','cost_shipping','cost_insurance','cost_additional','final_total');

}
