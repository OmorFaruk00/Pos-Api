<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Lecture;
use App\Http\Controllers\Controller;
use App\Models\Lecturesheet;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class LecturesheetController extends Controller
{
    function LectureAdd(Request $request)
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
                $file->move(public_path('images/lecturesheet'), $file_name);
            }
            $Lecture = new Lecturesheet();
            $Lecture->department = $request->department;
            $Lecture->batch = $request->batch;
            $Lecture->description = $request->description;
            $Lecture->course_name = $request->course_name;
            $Lecture->course_code = $request->course_code;
            $Lecture->status = 1;
            $Lecture->file = $file_name;
            $Lecture->created_by = auth()->user()->id;
            $Lecture->save();
            return response()->json(['message' => 'Lecture Sheet Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function LectureShow()
    {
        try {
            return Lecturesheet::with('Department','course','batch')->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function LectureEdit($id)
    {
        try {
            return Lecturesheet::find($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return Lecturesheet::find($id);
    }
    function LectureUpdate(Request $request, $id)
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
                $file->move(public_path('images/lecturesheet'), $file_name);
            }

            $Lecture = Lecturesheet::find($id);
            $Lecture->department = $request->department;
            $Lecture->batch = $request->batch;
            $Lecture->description = $request->description;
            $Lecture->course_name = $request->course_name;
            $Lecture->course_code = $request->course_code;
            $Lecture->status = 1;
            $Lecture->file = $file_name ?? $Lecture->file;
            $Lecture->created_by = auth()->user()->id;
            $Lecture->save();
            return response()->json(['message' => 'Lecture Sheet Update Successfully'], 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function LectureDelete($id)
    {
        try {
            $Lecture = Lecturesheet::find($id);
            $Lecture->delete();
            return response()->json(['message' => 'Lecture Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  
    
}
