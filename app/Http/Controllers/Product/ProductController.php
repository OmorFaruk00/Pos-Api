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

    public function test(Request $request){
        // Product::create($this->service->storeProduct($request));
        // $user = $request->storeUser();
        // return response()->json([$pro,$user]);
        // return 'success';
        // $this->service->storeProduct();
        return $this->service->storeProduct($request);
        return 'success';

    }

    public function index()
    {
        try {
            return Product::paginate(2);            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function create()
    {
        
        $product['unit'] = Unit::all('id','name');
        $product['brand'] = Brand::all('id','name');
        $product['category'] = Category::all('id','name');
        return response()->json($product);
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
        try {
            
            $product = Product::with('unit','category')->orderBy('id', 'desc')->paginate($id);
            return response()->json($product);
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
