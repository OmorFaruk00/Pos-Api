<?php

namespace App\Http\Controllers\EMP;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Validation\Rules\Password;

class EmployeeController extends Controller
{
    function EmployeeAdd(Request $request){
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'name' => 'required',
            'email' => 'required|unique:employees',                                    
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'department' => 'required',
            'designation' => 'required',
            'personal_phone_no' => 'required|numeric',
            'date_of_joining' => 'required',            
            'job_type' => 'required',             
            'nid_no' => 'required|numeric',
            'date_of_birth' => 'required',
            'supervised_by' => 'required',   
            'role' => 'required',                                  
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
        $Employee->parent_phone_no = $request->parent_phone_no;     
        $Employee->merit = $request->merit;
        $Employee->jobtype = $request->job_type;        
        $Employee->nid_no = $request->nid_no;
        $Employee->date_of_birth = $request->date_of_birth;
        $Employee->date_of_join = $request->date_of_joining;
        $Employee->supervised_by = $request->supervised_by;
        $Employee->role = $request->role;        
        $Employee->profile_photo = $file_name;
        $Employee->status = 1;
        $Employee->created_by = auth()->user()->id;        
        $Employee->save();
        return response()->json(['message' => 'Employee Added Successfully'],200);
    }


    
    function EmployeeShow(){
        try {            
            return Employee::with('relDesignation','relDepartment')->get();           
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }          
        
    }
    function EmployeeShowPaginate(){
        try {            
            return Employee::with('relDesignation','relDepartment')->paginate('5');           
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }          
        
    }
    function EmployeeEdit($id){        
        return Employee::find($id);
    }
    function EmployeeUpdate(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'email' => "required|unique:employees,email,".$id,                                   
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
            'department' => 'required',
            'designation' => 'required',
            'personal_phone_no' => 'required|numeric',
            'date_of_join' => 'required',            
            'jobtype' => 'required',             
            'nid_no' => 'required|numeric',
            'date_of_birth' => 'required',   
            'supervised_by' => 'required',   
            'role' => 'required',                                   
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
        

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/emp'), $file_name);
                        
        }
        $Employee = Employee::find($id);
        $Employee->name = $request->name;
        $Employee->email = $request->email;                
        $Employee->department_id = $request->department;
        $Employee->designation_id = $request->designation;
        $Employee->personal_phone_no = $request->personal_phone_no;      
        $Employee->alternative_phone_no = $request->personal_phone_no;      
        $Employee->home_phone_no = $request->personal_phone_no;
        $Employee->parent_phone_no = $request->parent_phone_no;       
        $Employee->merit = $request->merit;
        $Employee->jobtype = $request->jobtype;        
        $Employee->nid_no = $request->nid_no;
        $Employee->supervised_by = $request->supervised_by;
        $Employee->role = $request->role;
        $Employee->date_of_birth = $request->date_of_birth;
        $Employee->date_of_join = $request->date_of_join;      
        $Employee->profile_photo = $file_name ?? $Employee->profile_photo;
        $Employee->status = 1;
        $Employee->created_by = auth()->user()->id;        
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
    function EmployeeDetails($id){
        return Employee::with('relDesignation','relDepartment','relSocial','relTraining','relQualification')->where('id',$id)->first();
    }

    function EmployeeDelete($id){              
        $Employee = Employee::find($id);        
        // unlink(public_path() .'/images/emp/'. $Employee->image);
        $Employee->delete();
        return response()->json(['message' => 'Employee Deleted Successfully'],200);
    }
    function EmployeeRole(){
        return Role::all();
        
        
    }
   
        
        
        
    
}
