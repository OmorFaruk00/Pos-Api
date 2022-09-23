<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateRequest;
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
        $request->validate([
           'product_name'=> 'required|unique:products,product_name,'.$id,
           'product_code'=> 'required|unique:products,product_code,'.$id,
           'barcode'=> 'nullable|unique:products,barcode,'.$id,
           'category'=> 'required',
           'unit'=> 'required',
           'purchase_price'=> 'required|numeric',
           'sales_price'=> 'required|numeric',
           'opening_qty'=> 'required|numeric',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        try {            
            return $this->service->updateProduct($request,$id);            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function SearchProduct(Request $request){
        return $this->service->GetProductBySearch($request);
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
