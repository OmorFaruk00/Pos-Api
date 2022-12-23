<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class EmployeeRequest extends FormRequest
{
  
    public function authorize()
    {
        return true;
    }

 
    public function rules()
    {
        return [
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
            'email' => 'required|unique:employees,email',                                    
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'department' => 'required',
            'designation' => 'required',
            'personal_phone_no' => 'required|numeric',
            'branch' => 'required',            
            'job_type' => 'required',             
            'nid_no' => 'required|numeric',                        
            'role' => 'required',  
        ];
    }
}
