<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Repository\ProductRepository;
use App\Models\Product;

class ProductController extends Controller
{
   
    private $repository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

  

    public function index()
    {
        return $this->repository->GetProductDetails();
        
    }

    public function create()
    {        
       
    }

    public function store(ProductRequest $request)
    { 
        
        try {
             return $this->repository->storeProduct($request); 
                
        } catch (\Exception $e) {
            return $e->getMessage();
        }        
   
    }
 
    
    public function edit($id)
    {
        try {
            return Product::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(ProductRequest $request, $id)
    {
     
        try {
             return $this->repository->updateProduct($request,$id);   
                    
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
       
    }
    public function SearchProduct(Request $request){      
        try {            
            return $this->repository->GetProductBySearch($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {        
        try {
            return $this->repository->deleteProduct($id); 
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    public function StockProduct(Request $request){
        try {            
            return $this->repository->GetProductStockBySearch($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
  


}
