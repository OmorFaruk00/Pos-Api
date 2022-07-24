<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturesheet extends Model
{
    use HasFactory;
    public function Department()
    {
        return $this->hasOne('App\Models\Section','id','department');
    }
}
