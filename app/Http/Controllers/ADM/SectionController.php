<?php

namespace App\Http\Controllers\ADM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
   
   function departmentAdd(Request $request){        
      $request->validate([
          
          'department_name' => 'required',           
          
      ]);
      $department = new Section();
      $department->department_name = $request->department_name;             
      $department->status = 1;
      $department->created_by = auth()->user()->id;
      $department->save();
      return response()->json(['message' => 'Department Added Successfully'],200);
  }


  
  function departmentShow(){
      return Section::all();
      
      
  }
  function departmentEdit($id){
      return Section::find($id);

  }
  function departmentUpdate(Request $request,$id){
   $request->validate([
          
      'department_name' => 'required',           
      
  ]);
  $department = Section::find($id);
  $department->department_name = $request->department_name;             
  $department->status = 1;
  $department->created_by = auth()->user()->id;
  $department->save();  
      return response()->json(['message' => 'Department Updated Successfully'],200);

  }
  function departmentStatus($id){
      $department = Section::find($id);
      if($department->status ==0){
          $department->status = 1;
      }else{
          $department->status = 0;
      }
      $department->save();
      return response()->json(['message' => 'Department Status Change'],200);
  }
  function departmentDelete($id){
            
      $department = Section::find($id);
      $department->delete();
      return response()->json(['message' => 'Department Deleted Successfully'],200);
  }
}
