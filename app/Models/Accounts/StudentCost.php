<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transactionable()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
    public function relFeeType()
    {
        return $this->hasONe(PaymentPurpose::class, 'id', 'fee_type');
    }
}
