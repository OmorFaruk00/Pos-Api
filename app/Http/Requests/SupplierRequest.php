<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

  
    public function rules()
    {
        return [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'nullable',
                'opening_balance' => 'nullable',
                'address' => 'nullable',
        ];
    }
}
