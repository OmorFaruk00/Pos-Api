<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\EmployeeRequest;
use App\Http\Services\EmployeeService;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;

class EmployeeController extends Controller
{

    private $service;

    public function __construct(EmployeeService $employeeService)
    {
        $this->service = $employeeService;
    }
    public function index()
    {
        try {
            $employee['department'] = Department::select('id',"name")->get();
            $employee['designation'] = Designation::select('id',"name")->get();
            $employee['role'] = Role::select('id',"name")->get();            
            return response()->json($employee);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getEmployee(Request $request)
    {        
        try {
            return $this->service->GetEmployeeBySearch($request);   
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }       
        
    }

    public function store(EmployeeRequest $request)
    {    
        try {
            return $this->service->storeEmployee($request);   
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {

      
    }
    public function status($id)
    {
        try {
           return $this->service->CustomerStatus($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return Employee::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {        
        $request->validate([           
            'name' => 'required',
            'email' => 'required|unique:employees,email,'.$id,                                    
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'department' => 'required',
            'designation' => 'required',
            'personal_phone_no' => 'required|numeric',
            'branch' => 'required',            
            'job_type' => 'required',             
            'nid_no' => 'required|numeric',                        
            'role' => 'required',                                  
        ]);       
        try {
            return $this->service->updateEmployee($request,$id);  
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {        
        try {
            Employee::find($id)->delete();
            return response()->json(['message' => 'Designation Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
