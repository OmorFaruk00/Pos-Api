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
            $category = Category::select('id','name')->orderBy('id', 'desc')->get();
            return response()->json($category);
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
            $category = new Category();
            $category->name = $request->name;            
            $category->created_by = auth()->user()->id;
            $category->save();
            return response()->json(['message' => 'Category Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($list)
    {
        try {

            $category = Category::orderBy('id', 'desc')->paginate($list);
            return response()->json($category);
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
            $category = Category::findOrFail($id);
            $category->name = $request->name;           
            $category->updated_by = auth()->user()->id;
            $category->save();
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
