<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_report extends Model
{
    use HasFactory;
    public function student()
    {
        return $this->hasOne('App\Models\Student', 'id', 'student_id')->select('id','student_name', 'roll_no');
    }
}
