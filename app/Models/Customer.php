<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function category()
    {
        return $this->hasOne(CustomerCategory::class,'id','category_id');
    }
   
    // public function getNameAttribute($value)
    // {
    //     return 'Mr. '.ucfirst($value);
    // }
}
