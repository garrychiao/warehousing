<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = array('id','customer_id','company_name','chi_name','eng_name','short_name','owner','contact_person','email','phone','cell_phone','fax','consignee_name','consignee_contact','consignee_phone','consignee_zip','consignee_address','notify_name','notify_contact','notify_phone','notify_zip','notify_address','EIN','invoice','check','nationality','currency','remark');
}
