<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function relUnit()
    {
        return $this->hasOne('App\Models\Unit',  'id','unit');
    }
    public function relCategory()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category');
    }
    public function relBrand()
    {
        return $this->hasOne('App\Models\Brand',  'id','brand');
    }
    public function stock()
    {
        return $this->hasOne('App\Models\ProductStock',  'product_id','id');
    }
}
