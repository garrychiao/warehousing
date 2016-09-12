<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyCompany extends Model
{
  protected $fillable = array('name','owner','eng_name','EIN','contact_person','eng_address','address','phone','phone_foreign','cell_phone','fax','email','website','img_url');
}
