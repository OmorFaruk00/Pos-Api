<?php

namespace App\Http\Services;


use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class CustomerService
{
 
    public function storeCustomer($request)
    {
     
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/customer'), $file_name);
        }
          $customer  =  new Customer();
          $customer->name = $request->customer_name ;
          $customer->email = $request->email ;
          $customer->phone = $request->phone;
          $customer->category = $request->category;
          $customer->card_number = $request->card_number;
          $customer->due_limit = $request->due_limit;
          $customer->current_balance = $request->opening_balance;
          $customer->address = $request->address;
          $customer->image = $file_name ?? null;
          $customer->created_by = auth()->user()->id;
          $customer->save();
          return response()->json(['message' => 'Customer Added Successfully'], 201);


    }
    public function updateCustomer($request,$id)
    {    
      
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/customer'), $file_name);
        }
          $customer  =  Customer::findOrFail($id);
          $customer->name = $request->customer_name ;
          $customer->email = $request->email;
          $customer->phone = $request->phone;
          $customer->category = $request->category;
          $customer->card_number = $request->card_number;
          $customer->due_limit = $request->due_limit;
          $customer->current_balance = $request->opening_balance;
          $customer->address = $request->address;
          $customer->image = $file_name ?? $customer->image;
          $customer->created_by = auth()->user()->id;
          $customer->save();
          return response()->json(['message' => 'Customer Updated Successfully'], 201);
       
    }
    public function GetCustomerBySearch($request){
        $type = $request->type;
        $item = $request->item;
        $list = $request->list;     
        $search = $request->search;     

        if('search_by_category' == $type ){
            return Customer::with('category')->where('category',$item)->paginate($list);
        }
      
        else if('search_by_global'== $type){            
            return Customer::with('category')->where(function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('address', 'like', '%'.$search.'%');                    
            })->paginate($list);            
        }
        else{
            return Customer::with('category')->paginate($list);
        }
    }
    public function deleteCustomer($id)
    {
        
    }
}
