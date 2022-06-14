<?php

namespace App\Http\Controllers\EMP;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Controllers\Controller;



class DepartmentController extends Controller
{
    function DepartmentAdd(Request $request){
        $request->validate([
            'department' => 'required',
            'type' => 'required',           
        ]);

        $department = new Department();
        $department->type = $request->type;
        $department->department = $request->department;
        $department->status = 1;
        $department->created_by = auth()->user()->id;  
        $department->save();
        return response()->json(['message'=>'Department Added Successfully'],201);
    }


    
    function DepartmentShow(){
        return Department::all();
        
        
    }
    function DepartmentEdit($id){
        return Department::find($id);

    }
    function DepartmentUpdate(Request $request,$id){
        $request->validate([
            'department' => 'required',
            'type' => 'required',           
        ]);

        $department = Department::find($id);
        $department->type = $request->type;
        $department->department = $request->department;        
        $department->created_by = auth()->user()->name;  
        $department->save();
        return response()->json(['message' => 'Department Updated Successfully'],200);

    }
    function DepartmentStatus($id){
        // return $slug;
        $Department = Department::find($id);
        if($Department->status == 0){
            $Department->status = 1;
        }else{
            $Department->status = 0;
        }
        $Department->save();
        return response()->json(['message' => 'Department Status Change'],200);
    }
    function DepartmentDelete($id){              
        $Department = Department::find($id);     
        $Department->delete();
        return response()->json(['message' => 'Department Deleted Successfully'],200);
    }
        
        
        
    
}
