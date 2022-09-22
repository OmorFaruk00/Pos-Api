<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerCategory;

class CustomerCategoryController extends Controller
{
    public function index()
    {
        try {
            return CustomerCategory::select('id','name')->get();
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
            'name' => 'required|unique:customer_categories,name',

        ]);
        try {
            $CustomerCategory = new CustomerCategory();
            $CustomerCategory->name = $request->name;
            $CustomerCategory->created_by = auth()->user()->id;
            $CustomerCategory->save();
            return response()->json(['message' => 'Customer category Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            
            $CustomerCategory = CustomerCategory::orderBy('id', 'desc')->paginate($id);
            return response()->json($CustomerCategory);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return CustomerCategory::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:customer_categories,name,' . $id

        ]);
        try {
            $CustomerCategory = CustomerCategory::findOrFail($id);
            $CustomerCategory->name = $request->name;
            $CustomerCategory->updated_by = auth()->user()->id;
            $CustomerCategory->save();
            return response()->json(['message' => 'Customer category Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
       
        try {
            CustomerCategory::find($id)->delete();
            return response()->json(['message' => 'Customer category Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
