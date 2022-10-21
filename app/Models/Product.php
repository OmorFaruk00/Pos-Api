<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function relUnit()
    {
        return $this->hasOne('App\Models\Unit',  'id','unit');
    }
    public function relCategory()
    {
        return $this->belongsTo('App\Models\Category',  'category','id');
    }
    public function stock()
    {
        return $this->hasOne('App\Models\Product_stock',  'product_id','id');
    }
}
