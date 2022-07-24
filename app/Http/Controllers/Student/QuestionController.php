<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class QuestionController extends Controller
{
    function QuestionAdd(Request $request)
    {       

        $request->validate([
            'department' => 'required',
            'batch' => 'required',
            'course_name' => 'required',
            'course_code' => 'required|numeric',            
            'description' => 'required',            
            'file' => 'required|mimes:pdf|max:2048',

        ]);
        try {
         
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/question'), $file_name);
            }
            $Question = new Question();
            $Question->department = $request->department;
            $Question->batch = $request->batch;
            $Question->description = $request->description;
            $Question->course_name = $request->course_name;
            $Question->course_code = $request->course_code;
            $Question->status = 1;
            $Question->file = $file_name;
            $Question->created_by = auth()->user()->id;
            $Question->save();
            return response()->json(['message' => 'Question Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function QuestionShow()
    {
        try {
            return Question::with('Department')->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function QuestionEdit($id)
    {
        try {
            return Question::find($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return Question::find($id);
    }
    function QuestionUpdate(Request $request, $id)
    {
        $request->validate([
            'department' => 'required',
            'batch' => 'required',
            'course_name' => 'required',
            'course_code' => 'required|numeric',            
            'description' => 'required',            
            'new_file' => 'nullable|mimes:pdf|max:2048',
            

        ]);
        try {
           
            if ($request->hasFile('new_file')) {
                $file = $request->file('new_file');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/question'), $file_name);
            }

            $Question = Question::find($id);
            $Question->department = $request->department;
            $Question->batch = $request->batch;
            $Question->description = $request->description;
            $Question->course_name = $request->course_name;
            $Question->course_code = $request->course_code;
            $Question->status = 1;
            $Question->file = $file_name ?? $Question->file;
            $Question->created_by = auth()->user()->id;
            $Question->save();
            return response()->json(['message' => 'Question Update Successfully'], 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function QuestionDelete($id)
    {
        try {
            $Question = Question::find($id);
            $Question->delete();
            return response()->json(['message' => 'Question Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  
    
}
