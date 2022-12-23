<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        try {
            $Category = Category::select('id','name')->orderBy('id', 'desc')->get();
            return response()->json($Category);
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
            'name' => 'required|unique:categories,name',
        ]);
        try {
            $Category = new Category();
            $Category->name = $request->name;
            $Category->vat = $request->vat;
            $Category->created_by = auth()->user()->id;
            $Category->save();
            return response()->json(['message' => 'Category Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($list)
    {
        try {

            $Category = Category::orderBy('id', 'desc')->paginate($list);
            return response()->json($Category);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return Category::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:categories,name,' . $id

        ]);
        try {
            $Category = Category::findOrFail($id);
            $Category->name = $request->name;
            $Category->vat = $request->vat;
            $Category->updated_by = auth()->user()->id;
            $Category->save();
            return response()->json(['message' => 'Category Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {       
        try {
            Category::find($id)->delete();
            return response()->json(['message' => 'Category Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
