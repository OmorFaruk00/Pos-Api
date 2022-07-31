<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public function department()
    {
        return $this->hasOne('App\Models\Section','id','department');
    }
    public function course()
    {
        return $this->hasOne('App\Models\Course','course_code','course_code');
    }
    public function batch()
    {
        return $this->hasMany('App\Models\Batch', 'id', 'batch');
    }
}
