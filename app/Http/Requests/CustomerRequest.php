<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

  
    public function rules()
    {

        return [
            "name" => "required",
            "phone" => "required",
            "category_id" => "required",
            "email" => "nullable|email",
            "card_number" => "nullable",
            "due_limit" => "nullable",
            "address" => "nullable",
            "opening_balance" => "nullable",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category field is required.',

        ];
    }
}
