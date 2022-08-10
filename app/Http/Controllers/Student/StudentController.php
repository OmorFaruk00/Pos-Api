<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class StudentController extends Controller
{
    function studentShow()
    {
        try {            
            return Student::with('department','batch')->paginate('5');
            
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function courseShow($id)
    {
        try {            
            return Course::where('department_id',$id)->get();
            
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function courseCodeShow($id)
    {
        try { 
            // return $id;           
            return Course::find($id);
            
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  

  
    
}
