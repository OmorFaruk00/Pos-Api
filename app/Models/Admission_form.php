<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission_form extends Model
{
    use HasFactory;

    public function batch()
    {
        return $this->hasOne('App\Models\Batch',  'id','batch_id')->select('id','batch_name');
    }
    public function department()
    {
        return $this->hasOne('App\Models\Section',  'id','dept_id')->select('id','department_name');
    }
    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id','sale_by')->select('id','name');
    }
}
