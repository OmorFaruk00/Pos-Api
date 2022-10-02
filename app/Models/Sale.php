<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    public function sale_details()
    {
        return $this->hasMany('App\Models\Sale_detail',  'sale_id','id');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer',  'id','customer_id');
    }
}
