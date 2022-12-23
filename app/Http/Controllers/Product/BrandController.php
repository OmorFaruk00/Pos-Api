<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{

    public function index()
    {
        try {
            
            $Brand = Brand::select('id','name')->orderBy('id', 'desc')->get();
            return response()->json($Brand);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',

        ]);
        try {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->created_by = auth()->user()->id;
            $brand->save();
            return response()->json(['message' => 'Brand Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            
            $Brand = Brand::orderBy('id', 'desc')->paginate($id);
            return response()->json($Brand);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return Brand::findorfail($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:brands,name,' . $id

        ]);
        try {
            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;
            $brand->updated_by = auth()->user()->id;
            $brand->save();
            return response()->json(['message' => 'Brand Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
