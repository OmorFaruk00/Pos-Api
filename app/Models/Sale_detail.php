<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_detail extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->hasOne('App\Models\Product',  'id','product_id')->select('id','product_name','product_code','category');
    }
}
