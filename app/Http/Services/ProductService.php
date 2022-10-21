<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\Product_stock;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class ProductService
{
    public function GetProductDetails(){
        $product['unit'] = Unit::all('id','name');
        $product['brand'] = Brand::all('id','name');
        $product['category'] = Category::all('id','name');
        return response()->json($product);

    }
    public function storeProduct($request)
    {
       

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/product'), $file_name);
        }
        $data = new Product();
        $data->product_name = $request->product_name;
        $data->product_code = $request->product_code;
        $data->brand = $request->brand;
        $data->category = $request->category;
        $data->unit = $request->unit;
        $data->tax = $request->tax;
        $data->purchase_price = $request->purchase_price;
        $data->sales_price = $request->sales_price;
        $data->barcode = $request->barcode;
        $data->opening_qty = $request->opening_qty;
        $data->alert_qty = $request->alert_qty;
        $data->discount = $request->discount;
        $data->warranty = $request->warranty;
        $data->guarantee = $request->guarantee;
        $data->description = $request->description;
        $data->image = $file_name ?? null;
        $data->created_by = auth()->user()->id;
        $data->save();

        $stock = new Product_stock();
        $stock->product_id = $data->id;
        $stock->opening_quantity = $request->opening_qty;
        $stock->available_quantity = $request->opening_qty;
        $stock->created_by = auth()->user()->id;
        $stock->save();
        return response()->json(['message' => 'Product Added Successfully'], 200);
    }
    public function updateProduct($request,$id)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/product'), $file_name);
        }
        $data = Product::findOrFail($id);
        $data->product_name =  $request->product_name;
        $data->product_code = $request->product_code;
        $data->brand = $request->brand;
        $data->category = $request->category;
        $data->unit = $request->unit;
        $data->tax = $request->tax;
        $data->purchase_price = $request->purchase_price;
        $data->sales_price = $request->sales_price;
        $data->barcode = $request->barcode;
        $data->opening_qty = $request->opening_qty;
        $data->alert_qty = $request->alert_qty;
        $data->warranty = $request->warranty;
        $data->guarantee = $request->guarantee;
        $data->discount = $request->discount;
        $data->description = $request->description;
        $data->image = $file_name ?? $data->image;
        $data->updated_by = auth()->user()->id;
        $data->save();

        $stock = Product_stock::where('product_id',$id)->first();       
        $stock->opening_quantity = $request->opening_qty;        
        $stock->updated_by = auth()->user()->id;
        $stock->save();
        return response()->json(['message' => 'Product Updated Successfully'], 200);
    }
    public function GetProductBySearch($request){    
        
        $query = $this->searchProduct($request);
     
         $query->transform(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'code' => $product->product_code,
                'category' => $product->relcategory->name,
                'unit' => $product->relunit->name,
                'price' => $product->sales_price,
                'available_quantity' => $product->stock->available_quantity,
                'discount' => $product->discount,
                'image' => $product->image,          
            ];
        });
        
        return $query;
    
    }   

    public function GetProductStockBySearch($request){

        $query = $this->searchProduct($request);

        $result = $query->getCollection()->transform(function($product) {
            return [
                'name' => $product->product_name,
                'code' => $product->product_code,                
                'available_quantity' => $product->stock->available_quantity,
                'sold_quantity' => $product->stock->sold_quantity,
                'purchased_qty' => $product->stock->purchased_quantity,
                'wastage_quantity' => $product->stock->wastage_quantity,             
                     
            ];
        });
        
        return $query;
    }
    public function deleteProduct($id)
    {
        Product::find($id)->delete();
        Product_stock::where('product_id',$id)->delete();
    }
    public function searchProduct($request){
        $type = $request->type;
        $item = $request->item;
        $list = $request->list;     
        $search = $request->search;     

        $query = Product::with('relUnit','relCategory','stock')     
        ->when($type=='brand', function ($q) use ($type,$item) {
             $q->where('brand','=',$item);
        })
        ->when($type=='category', function ($q) use ($type,$item) {
             $q->where('category','=',$item);
        })
        ->when($type=='global', function ($q) use ($type,$search) {                   
            $q->where('product_name', 'like', '%'.$search.'%')
                ->orWhere('product_code', 'like', '%'.$search.'%')
                ->orWhere('barcode', 'like', '%'.$search.'%')
                ->orWhere('sales_price', 'like', '%'.$search.'%');                    
        })
        ->orderBy('id', 'desc')            
        ->paginate($list); 
        return $query;

    }
}
