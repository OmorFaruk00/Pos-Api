<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID';
    public function sale_details()
    {
        return $this->hasMany(Sale_detail::class,  'sale_id','id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class,  'id','customer_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class,  'id','product_id');
    }

    // public function getIdAttribute($value)
    // {
    //     return 'POS'.$value;
    // }
}
