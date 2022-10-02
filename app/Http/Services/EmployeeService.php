<?php

namespace App\Http\Services;


use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;




class EmployeeService
{
 
    public function storeEmployee($request)
    {     
        if ($request->hasFile('image')) {
            $file = $request->file('image');     

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/employee'), $file_name);                      
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
        $Employee->jobtype = $request->job_type;        
        $Employee->nid_no = $request->nid_no;
        $Employee->date_of_birth = $request->date_of_birth;
        $Employee->branch = $request->branch;           
        $Employee->role = $request->role;        
        $Employee->image= $file_name ?? null;
        $Employee->status = 1;
        $Employee->created_by = auth()->user()->id;        
        $Employee->save();
        return response()->json(['message' => 'Employee Added Successfully'],200);


    }
    public function updateEmployee($request,$id)
    {    
      
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/employee'), $file_name);
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
        $Employee->jobtype = $request->job_type;        
        $Employee->nid_no = $request->nid_no;
        $Employee->date_of_birth = $request->date_of_birth;
        $Employee->branch = $request->branch;            
        $Employee->role = $request->role;        
        $Employee->image = $file_name ?? $Employee->image;
           
        $Employee->save();
        return response()->json(['message' => 'Employee Updated Successfully'],200);
       
    }
    public function GetEmployeeBySearch($request){
        $search = $request->search;
        $list = $request->list;
        if($search!=null){
            return Employee::with('designation','department')->where(function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('personal_phone_no', 'like', '%'.$search.'%');                   
            })->paginate($list); 

        }else{
            return Employee::with('designation','department')->orderBy('id', 'desc')->paginate(2);

        }
    }
    public function CustomerStatus($id)
    {
        $Employee = Employee::find($id);
        if($Employee->status ==0){
            $Employee->status = 1;
        }else{
            $Employee->status = 0;
        }
        $Employee->save();
        return response()->json(['message' => 'Employee Status Changed Successfully'],200);
        
    }
}
