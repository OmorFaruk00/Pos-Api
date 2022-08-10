<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCost extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function relTransaction()
    {
        return $this->hasOne(Transaction::class,'id','transaction_id');
    }
    public function relFeeType()
    {
        return $this->hasONe(PaymentPurpose::class,'id','fee_type');
    }
}
