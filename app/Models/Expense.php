<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','amount','purpose','date','created_by', 'description'];

    public function category(){
        return $this->hasOne(ExpenseCategory::class,'id','category_id');
    }
}
