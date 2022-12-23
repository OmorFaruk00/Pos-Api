<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Repository\CustomerRepository;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    private $repository;

    public function __construct(CustomerRepository $customerRepository)
    {        
        $this->repository = $customerRepository;
    }
       
    public function index()
    {
        try {
            return $this->repository->getCustomer(); 
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }   
    public function SearchCustomer(Request $request){
        try {
            return $this->repository->GetCustomerBySearch($request);           
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
        
    }
   
    public function store(CustomerRequest $request)
    {      
        try {
            return $this->repository->storeCustomer($request);            
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
        
    }    
    public function edit($id)
    {
        try {
            return $this->repository->editCustomer($id);  
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function update(CustomerRequest $request, $id)
    {      
        try {
            return $this->repository->updateCustomer($request,$id);            
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
       
    }
    public function destroy($id)
    {
        try {
            return $this->repository->deleteCustomer($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
