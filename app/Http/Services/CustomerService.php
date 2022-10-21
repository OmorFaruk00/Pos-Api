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
          $customer->category_id = $request->category;
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
          $customer->category_id = $request->category;
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
        
        $query = Customer::with('category')        
        ->when($type=='category', function ($q) use ($type,$item) {
             $q->where('category_id','=',$item);
        })
        ->when($type=='global', function ($q) use ($type,$search) {                   
            $q->where('name', 'like', '%'.$search.'%')
            ->orWhere('phone', 'like', '%'.$search.'%')
            ->orWhere('address', 'like', '%'.$search.'%');                    
        }) 
        ->orderBy('id', 'desc')           
        ->paginate($list); 

        $query->transform(function($customer){
            return[
                'id'=>$customer->id,
                'name'=>$customer->name,
                'email'=>$customer->email,
                'phone'=>$customer->phone,
                'category'=>$customer->category->name,
                'image'=>$customer->image,
            ];

        });

        return $query;

       
    }
    public function deleteCustomer($id)
    {
        
    }
}
