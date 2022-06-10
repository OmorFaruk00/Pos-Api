<?php

namespace App\Http\Controllers\EMP;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class EmployeeController extends Controller
{
    function EmployeeAdd(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees', 
            'password' => 'required|confirmed',                        
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'department' => 'required',
            'designation' => 'required',
            'personal_phone_no' => 'required',
            'date_of_joining' => 'required',            
            'job_type' => 'required',             
            'nid_no' => 'required',
            'date_of_birth' => 'required',   
            

                                   
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
        

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/emp'), $file_name);
            $image_url = env('APP_URL') . "/images/emp/$file_name";            
        }
        $Employee = new Employee();
        $Employee->name = $request->name;
        $Employee->email = $request->email;
        $Employee->password = Hash::make($request->password);        
        $Employee->department_id = $request->department;
        $Employee->designation_id = $request->designation;
        $Employee->personal_phone_no = $request->personal_phone_no;      
        $Employee->alternative_phone_no = $request->personal_phone_no;      
        $Employee->home_phone_no = $request->personal_phone_no;     
        $Employee->merit = $request->merit;
        $Employee->jobtype = $request->job_type;        
        $Employee->nid_no = $request->nid_no;
        $Employee->date_of_birth = $request->date_of_birth;
        $Employee->date_of_join = $request->date_of_joining;        
        $Employee->profile_photo = $file_name;
        $Employee->status = 1;
        $Employee->created_by = auth()->user()->name;        
        $Employee->save();
        return response()->json(['message' => 'Employee Added Successfully'],200);
    }


    
    function EmployeeShow(){
        return Employee::with('relDesignation','relDepartment')->get();
        
        
    }
    function EmployeeEdit($id){
        return Employee::find($id);

    }
    function EmployeeUpdate(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'description' => 'required', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',           
            
        ]);
        $Employee = Employee::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');       

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
            $image_url = env('APP_URL') . "/images/dum/$file_name"; 
            unlink(public_path() .'/images/dum/'. $Employee->image);          
        }
        
        $Employee->title = $request->title;
        $Employee->description = $request->description;     
        $Employee->image = $file_name??$Employee->image;
        $Employee->status = 1;
        $Employee->created_by = auth()->user()->name;        
        $Employee->save();
        return response()->json(['message' => 'Employee Updated Successfully'],200);

    }
    function EmployeeStatus($id){
        $Employee = Employee::find($id);
        if($Employee->status ==0){
            $Employee->status = 1;
        }else{
            $Employee->status = 0;
        }
        $Employee->save();
        return response()->json(['message' => 'Employee Status Change'],200);
    }
    function EmployeeDelete($id){              
        $Employee = Employee::find($id);        
        // unlink(public_path() .'/images/emp/'. $Employee->image);
        $Employee->delete();
        return response()->json(['message' => 'Employee Deleted Successfully'],200);
    }
    public function Employeeprofile(){
        $user_id = auth()->user()->id;
        $user = Employee::with('relDesignation','relDepartment')->where('id',$user_id)->first();
        return response()->json(['user'=>$user],200);
    }
        
        
        
    
}
