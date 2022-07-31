<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class CourseController extends Controller
{
    function CourseAdd(Request $request)
    {       

        $request->validate([
            'department' => 'required',
            'batch' => 'required',
            'course_name' => 'required',
            'course_code' => 'required',           
            

        ]);
        try {         
         
            $course = new Course();
            $course->department_id = $request->department;
            $course->batch_id = $request->batch;            
            $course->course_name = $request->course_name;
            $course->course_code = $request->course_code;
            $course->status = 1;            
            $course->created_by = auth()->user()->id;
            $course->save();
            return response()->json(['message' => 'Course Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function CourseShow()
    {
        try {
            return Course::with('department','batch')->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function CourseEdit($id)
    {
        try {
            return Course::find($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return course::find($id);
    }
    function CourseUpdate(Request $request, $id)
    {
        $request->validate([
            'department' => 'required',
            'batch' => 'required',
            'course_name' => 'required',
            'course_code' => 'required',            
           
            

        ]);
        try {
           
            if ($request->hasFile('new_file')) {
                $file = $request->file('new_file');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/course'), $file_name);
            }

            $course = Course::find($id);
            $course->department_id = $request->department;
            $course->batch_id = $request->batch;            
            $course->course_name = $request->course_name;
            $course->course_code = $request->course_code;
            $course->status = 1;            
            $course->created_by = auth()->user()->id;
            $course->save();
            return response()->json(['message' => 'Course Update Successfully'], 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function CourseDelete($id)
    {
        try {
            $course = Course::find($id);
            $course->delete();
            return response()->json(['message' => 'Course Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  
    
}
