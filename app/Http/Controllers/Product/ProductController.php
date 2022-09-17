<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Services\ProductService;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    private $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    public function SearchProduct(Request $request){
        return $this->service->GetProductBySearch($request);
    }

    public function index()
    {
        return $this->service->GetProductDetails();
        
    }

    public function create()
    {        
       
    }

    public function store(ProductRequest $request)
    {
        try {
            return $this->service->storeProduct($request);            
        } catch (\Exception $e) {
            return $e->getMessage();
        }        
   
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        try {
            return Product::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // return $request;
            return $this->service->updateProduct($request,$id);            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {        
        try {
            return $this->service->deleteProduct($id);  
            return response()->json(['message' => 'Product Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
