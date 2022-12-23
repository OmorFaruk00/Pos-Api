<?php

namespace App\Http\Repository;

use App\Models\{Product, ProductStock, Unit, Brand, Category};
use App\Traits\ImageUpload;




class ProductRepository
{
    use ImageUpload;

    public function GetProductDetails()
    {
        $product['unit'] = Unit::all('id', 'name');
        $product['brand'] = Brand::all('id', 'name');
        $product['category'] = Category::all('id', 'name');
        return response()->json($product);
    }

    public function storeProduct($request)
    {

        if ($request->hasFile('image')) {
            $image = $this->imageUpload($request, 'product');
        }
        $validatedData = $request->validated();

        $validatedData['created_by'] = auth()->user()->id;
        $validatedData['image'] = $image ?? null;
        $product_id = Product::insertGetId($validatedData);
        ProductStock::create(['product_id' => $product_id]);

        return response()->json(['message' => 'Product Added Successfully'], 200);
    }

    public function updateProduct($request, $id)
    {
        $product = Product::findOrFail($id);
        if ($request->hasFile('image')) {

            $image = $this->imageUpload($request, 'product');
        } else {
            $image = $product->image;
        }
        $validatedData = $request->validated();
        $validatedData['updated_by'] = auth()->user()->id;
        $validatedData['image'] = $image;
        $product->update($validatedData);
        return response()->json(['message' => 'Product Updated Successfully'], 200);
    }
    public function GetProductBySearch($request)
    {

        $query = $this->searchProduct($request);

        $query->transform(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'code' => $product->product_code,
                'category' => $product->relCategory->name,
                'brand' => $product->relBrand->name,
                'unit' => $product->relunit->name,
                'price' => $product->sales_price,
                'purchase_price' => $product->purchase_price,
                'available_quantity' => $product->stock->available_quantity ?? 0,
                'discount' => $product->discount,
                'image' => $product->image,
            ];
        });

        return $query;
    }

    public function GetProductStockBySearch($request)
    {

        $query = $this->searchProduct($request);

        $result = $query->getCollection()->transform(function ($product) {
            return [
                'name' => $product->product_name,
                'code' => $product->product_code,
                'brand' => $product->relBrand->name,
                'category' => $product->relCategory->name,
                'available_quantity' => $product->stock->available_quantity ?? 0,
                'sold_quantity' => $product->stock->sold_quantity ?? 0,
                'purchased_qty' => $product->stock->purchased_quantity ?? 0,
                'wastage_quantity' => $product->stock->wastage_quantity ?? 0,

            ];
        });

        return $query;
    }
    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        ProductStock::where('product_id', $id)->delete();
        return response()->json(['message' => 'Product Delete Successfully'], 201);
    }
    public function searchProduct($request)
    {
        $brand = $request->brand;
        $category = $request->category;
        $search = $request->search;
        $list = $request->list;

        $query = Product::with('relUnit', 'relBrand', 'relCategory', 'stock')
            ->when($brand != null, function ($q) use ($brand) {
                $q->where('brand', '=', $brand);
            })
            ->when($category != null, function ($q) use ($category) {
                $q->where('category', '=', $category);
            })
            ->when($search != null, function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('product_code', 'like', '%' . $search . '%')
                    ->orWhere('barcode', 'like', '%' . $search . '%')
                    ->orWhere('sales_price', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($list);

        return $query;
    }
}
