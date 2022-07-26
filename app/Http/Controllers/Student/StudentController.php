<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class StudentController extends Controller
{
    function studentShow()
    {
        try {            
            return Student::with('department','batch')->paginate('2');
            
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  

  
    
}
