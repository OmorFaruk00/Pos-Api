<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use App\Models\Lessonplan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class LessonplanController extends Controller
{
    function LessonAdd(Request $request)
    {       

        $request->validate([
            'department' => 'required',
            'batch' => 'required',
            'course_name' => 'required',
            'course_code' => 'required',            
            'description' => 'required',            
            'file' => 'required|mimes:pdf|max:2048',

        ]);
        try {
         
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/lessonplan'), $file_name);
            }
            $Lesson = new Lessonplan();
            $Lesson->department = $request->department;
            $Lesson->batch = $request->batch;
            $Lesson->description = $request->description;
            $Lesson->course_name = $request->course_name;
            $Lesson->course_code = $request->course_code;
            $Lesson->status = 1;
            $Lesson->file = $file_name;
            $Lesson->created_by = auth()->user()->id;
            $Lesson->save();
            return response()->json(['message' => 'Lesson Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function LessonShow()
    {
        try {
            return Lessonplan::with('Department','course','batch')->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function LessonEdit($id)
    {
        try {
            return Lessonplan::find($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return Lessonplan::find($id);
    }
    function LessonUpdate(Request $request, $id)
    {
        $request->validate([
            'department' => 'required',
            'batch' => 'required',
            'course_name' => 'required',
            'course_code' => 'required',            
            'description' => 'required',            
            'new_file' => 'nullable|mimes:pdf|max:2048',
            

        ]);
        try {
           
            if ($request->hasFile('new_file')) {
                $file = $request->file('new_file');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/lessonplan'), $file_name);
            }

            $Lesson = Lessonplan::find($id);
            $Lesson->department = $request->department;
            $Lesson->batch = $request->batch;
            $Lesson->description = $request->description;
            $Lesson->course_name = $request->course_name;
            $Lesson->course_code = $request->course_code;
            $Lesson->status = 1;
            $Lesson->file = $file_name ?? $Lesson->file;
            $Lesson->created_by = auth()->user()->id;
            $Lesson->save();
            return response()->json(['message' => 'Lesson Update Successfully'], 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function LessonDelete($id)
    {
        try {
            $Lesson = Lessonplan::find($id);
            $Lesson->delete();
            return response()->json(['message' => 'Lesson Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  
    
}
