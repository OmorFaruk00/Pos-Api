<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function relSubFunds(){
        return $this->hasMany(SubFund::class,'id','fund_id');
    }

// all database works
    public static function makeFund($req): Fund{
       return self::create([
            'name'=>$req['name'],
            'total_cash'=>$req['total']
        ]);
    }
}
