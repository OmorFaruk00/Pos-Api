<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class LeaveApplication extends Model
{
    use HasFactory;
    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }
    public function applied_by()
    {
        return $this->hasOne(Employee::class,'id','applied_by')->select('id','name','designation_id');        
        
    }
    public function approved_by()
    {
        return $this->hasOne(Employee::class,  'id', 'approved_by')->select('id','name','designation_id');   
       
    }
}
