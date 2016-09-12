<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = array('supplier_id','supplier_name','short_name','owner','phone','cell_phone','fax','email','zip_code','address','remark');
}
