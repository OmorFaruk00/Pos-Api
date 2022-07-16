<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function make($req): Classes
    {
        return self::create([
            'name' => $req['name'],
            'admission_fee' => $req['admissionFee'],
            'monthly_fee' => $req['monthlyFee'],
        ]);
    }
}
