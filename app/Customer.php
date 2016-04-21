<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = array('id','customer_id','company_name','chi_name','eng_name','short_name','owner','contact_person','email','phone','cell_phone','fax','contact_zip_code','contact_address','recieve_zip_code','recieve_address','EIN','invoice','check','nationality','currency','remark');
}
