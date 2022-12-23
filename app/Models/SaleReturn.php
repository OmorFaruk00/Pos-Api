<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->hasOne(Customer::class,  'id','customer_id');
    }
    public function return_info()
    {
        return $this->hasMany(SaleReturnDetail::class,  'sale_return_id','id');
    }
}
