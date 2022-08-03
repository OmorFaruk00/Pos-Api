<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function department()
    {
        return $this->hasMany('App\Models\Section','id','department_id')->select('id','department_name');
    }
    public function batch()
    {
        return $this->hasMany('App\Models\Batch', 'id', 'batch_id')->select('id','batch_name');
    }
    public function teacher()
    {
        return $this->hasMany('App\Models\Employee', 'id', 'assigned_by_id')->select('id','name');
    }
}
