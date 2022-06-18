<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission_form extends Model
{
    use HasFactory;

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch', 'batch_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo('App\Models\Course', 'batch_id', 'id');
    }
}
