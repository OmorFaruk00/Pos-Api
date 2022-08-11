<?php

namespace App\Models\Accounts;

use App\Models\Batch;
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
        return $this->hasOne(PaymentPurpose::class, 'id', 'fee_type');
    }
    public function relBatch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }
}
