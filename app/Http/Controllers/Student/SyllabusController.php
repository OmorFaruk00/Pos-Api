<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class SyllabusController extends Controller
{
    function SyllabusAdd(Request $request)
    {

        $request->validate([
            'department' => 'required',
            'status' => 'required',
            'description' => 'required',           
            'file' => 'required|mimes:pdf|max:2048',

        ]);
        try {
         
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/syllabus'), $file_name);
            }
            $Syllabus = new Syllabus();
            $Syllabus->department = $request->department;
            $Syllabus->description = $request->description;           
            $Syllabus->status = $request->status;
            $Syllabus->file = $file_name;
            $Syllabus->created_by = auth()->user()->id;
            $Syllabus->save();
            return response()->json(['message' => 'Syllabus Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function SyllabusShow()
    {
        try {
            return Syllabus::all();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function SyllabusEdit($id)
    {
        try {
            return Syllabus::find($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return Syllabus::find($id);
    }
    function SyllabusUpdate(Request $request, $id)
    {
        $request->validate([
            'department' => 'required',
            'status' => 'required',
            'description' => 'required',            
            'new_file' => 'nullable|mimes:pdf|max:2048',           

        ]);
        try {
           
            if ($request->hasFile('new_file')) {
                $file = $request->file('new_file');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/syllabus'), $file_name);
            }

            $Syllabus = Syllabus::find($id);
            $Syllabus->department = $request->department;
            $Syllabus->description = $request->description;           
            $Syllabus->status = $request->status;
            $Syllabus->file = $file_name ?? $Syllabus->file;
            $Syllabus->created_by = auth()->user()->id;
            $Syllabus->save();
            return response()->json(['message' => 'Syllabus Update Successfully'], 201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    function SyllabusDelete($id)
    {
        try {
            $Syllabus = Syllabus::find($id);
            $Syllabus->delete();
            return response()->json(['message' => 'Syllabus Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  
    
}
