<?php

namespace App\Models\Accounts;

use App\Models\Batch;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentPurpose extends Model
{
    use HasFactory;

    protected  $guarded = [];

    public function relDepartment(): HasOne
    {
        return $this->hasOne(Section::class, 'id', 'department_id')->select('id','department_name');
    }
    public function relBatch(): HasOne
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id')->select('id','batch_name');
    }
    //all database works
    public static function make($req): PaymentPurpose
    {
        return self::create([
            'name' => $req['name'],
            'amount' => $req['amount'],
            'fund_id' => $req['fund_id'],
            'sub_fund_id' => $req['sub_fund_id'],
            'department_id' => $req['department_id'],
            'batch_id' => $req['batch_id'],
            'month_wise' => $req['sub_fund_id'] ? $req['sub_fund_id'] : 0,
        ]);
    }
}
