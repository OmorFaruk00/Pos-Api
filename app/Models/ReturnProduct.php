<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->hasOne(Customer::class,  'id','customer_id');
    }
    public function return_info()
    {
        return $this->hasMany(ReturnProductDetail::class,  'product_return_id','id');
    }
    // public function getCreatedAtAttribute($date){
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }
    
}
