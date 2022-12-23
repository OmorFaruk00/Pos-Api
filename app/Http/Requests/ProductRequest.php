<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {

        return [
            'product_name' => 'required',
            'product_code' => [
                'required',
                Rule::unique('products')->ignore($this->id),
            ],
            'barcode' => [
                'required',
                Rule::unique('products')->ignore($this->id),
            ], 
            'image' =>[
                'image','mimes:jpeg,png,jpg,gif,svg','max:2048',
                Rule::requiredIf($this->id==null),
            ],        
            'category' => 'required',
            'brand' => 'nullable',
            'unit' => 'required',
            'purchase_price' => 'required|numeric',
            'sales_price' => 'required|numeric',
            'opening_qty' => 'nullable',
            'tax' => 'nullable',
            'alert_qty' => 'nullable',
            'warranty' => 'nullable',
            'guarantee' => 'nullable',
            'discount' => 'nullable',
            'description' => 'nullable',
           

        ];
    }
}
