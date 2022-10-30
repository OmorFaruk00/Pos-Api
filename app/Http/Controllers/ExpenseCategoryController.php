<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        try {            
            $Category = ExpenseCategory::orderBy('id', 'desc')->get();
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

        $data  = $this->validate($request,
        [
            'name' => 'required|unique:expense_categories,name',           
            'description'   => 'nullable',
        ],
        // [
        //     'name.required'     => ' name is required.',           
        // ]
        );
        
        try {
            $data['created_by'] = auth()->user()->id;
            $result = ExpenseCategory::insert($data);
            return response()->json(['message' => 'Category Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($list)
    {
        try {            
            $Category = ExpenseCategory::orderBy('id', 'desc')->paginate($list);
            return response()->json($Category);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return ExpenseCategory::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request,
        [
            'name' => 'required|unique:expense_categories,name,' . $id,         
            'description'   => 'nullable',
        ],
        );

        try {
            $Category = ExpenseCategory::findOrFail($id);
            $Category->update($data);           
            return response()->json(['message' => 'Category Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            ExpenseCategory::find($id)->delete();
            return response()->json(['message' => 'Category Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
