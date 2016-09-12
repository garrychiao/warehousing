<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryKitMember extends Model
{
  protected $fillable = array('kits_id','inventory_id','inventory_name','quantity');
}
