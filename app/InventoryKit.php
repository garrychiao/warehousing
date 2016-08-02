<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryKit extends Model
{
  protected $fillable = array('kits_id','kits_name','kits_description','kits_weight','price1','price2','price3','price4','price5','price6');
}
