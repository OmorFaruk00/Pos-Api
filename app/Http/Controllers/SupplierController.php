<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\SupplierRepository;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    private $repository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->repository = $supplierRepository;
    }
 

    public function index()
    {
        try {
            return $this->repository->getSupplier();
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(SupplierRequest $request)
    {
        
        try {
            return $this->repository->storeSupplier($request->validated());

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    

    public function edit($id)
    {
        try {
            return $this->repository->editSupplier($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(SupplierRequest $request, $id)
    {
        try {
            return $this->repository->updateSupplier($request->validated(),$id);
         
        } catch (\Exception $e) {
            return $e->getMessage();
        }       

    }
    public function SupplierList(Request $request)
    {
        try {
            return $this->repository->SupplierListBySearch($request);
         
        } catch (\Exception $e) {
            return $e->getMessage();
        }
      
    }

    public function destroy($id)
    {
        try {
            return $this->repository->deleteSupplier($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
