<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function unit()
    {
        return $this->hasOne('App\Models\Unit',  'id','unit')->select('id','name');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category',  'category','id')->select('id','name');
    }
    public function stock()
    {
        return $this->hasOne('App\Models\Product_stock',  'product_id','id')->select('id','product_id','available_quantity','purchased_quantity','sold_quantity','wastage_quantity');
    }
}
