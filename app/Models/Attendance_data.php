<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_data extends Model
{
    use HasFactory;
    public function report()
    {
        return $this->hasMany('App\Models\Attendance_report', 'attendance_data_id', 'id');
    }
    public function batch()
    {
        return $this->hasOne('App\Models\Batch', 'id','batch_id')->select('id','batch_name');
    }
}
