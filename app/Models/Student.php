<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    public function education()
    {
        return $this->hasOne('App\Models\Education', 'student_reg_code', 'reg_code');
    }
}
