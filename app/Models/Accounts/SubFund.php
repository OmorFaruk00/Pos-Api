<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubFund extends Model
{
    use HasFactory;

    protected $guarded = [];


//relationships



    //all database works
    public static function makeSubFund($req): SubFund
    {
        return self::create([
            'name' => $req['name'],
            'fund_id' => $req['fund_id'],
            'total' => $req['total']
        ]);
    }
    public function relFund()
    {
        return $this->belongsTo(Fund::class, 'fund_id');
    }
}
