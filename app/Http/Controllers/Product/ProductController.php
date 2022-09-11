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

class ProductController extends Controller
{
    
    private $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    public function test(Request $request){
        Product::create($this->service->storeProduct($request));
        // $user = $request->storeUser();
        // return response()->json([$pro,$user]);
        // return 'success';
        // $this->service->storeProduct();
        // return $this->service->storeProduct();
        return 'success';

    }

    public function index()
    {
        
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
      return $request->storeProduct();
       
    }

    public function show($id)
    {
        try {
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return Brand::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {

        
    }

    public function destroy($id)
    {
        // return $id;
        try {
            Brand::find($id)->delete();
            return response()->json(['message' => 'Brand Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
