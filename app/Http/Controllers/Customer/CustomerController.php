<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Http\Services\CustomerService;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    private $service;

    public function __construct(CustomerService $customerService)
    {        
        $this->service = $customerService;
    }
   
    public function index()
    {
        //
    }

   
    public function SearchCustomer(Request $request){
        return $this->service->GetCustomerBySearch($request);
    }
   
    public function store(CustomerRequest $request)
    {      
        try {
            return $this->service->storeCustomer($request);            
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
        
    }    
    public function edit($id)
    {
        try {
            return Customer::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } 

    
    public function update(Request $request, $id)
    {      
        try {
            return $this->service->updateCustomer($request,$id);            
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
       
    }

 
    public function destroy($id)
    {
        try {
            Customer::find($id)->delete();
            return response()->json(['message' => 'Customer Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
