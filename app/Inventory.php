<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = array('item_id','category','item_name','standard','graph_id','barcode','inventory','unit','safety_inventory','unit_weight','preserved_inv','shipped_inv','avg_cost','price1','price2','price3','price4','price5','price6','descriptions','remark');
}
