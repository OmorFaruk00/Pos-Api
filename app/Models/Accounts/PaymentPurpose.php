<?php

namespace App\Models\Accounts;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentPurpose extends Model
{
    use HasFactory;

    protected  $guarded = [];

    public function relClass():HasOne
    {
        return $this->hasOne(Department::class,'id','id');
    }
//all database works
    public static function make($req): PaymentPurpose
    {
        return self::create([
            'name' => $req['name'],
            'amount' => $req['amount'],
            'fund_id' => $req['fund_id'],
            'class_id' => $req['class_id'],
            'sub_fund_id' => $req['sub_fund_id'],
            'month_wise' => $req['sub_fund_id'] ? $req['sub_fund_id']:0,
        ]);
    }
}
