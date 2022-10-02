<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $Department = Department::orderBy('id', 'desc')->paginate(8);
            return response()->json($Department);
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
            'name' => 'required|unique:departments,name',
        ]);
        try {
            $Department = new Department();
            $Department->name = $request->name;
            $Department->created_by = auth()->user()->id;
            $Department->save();
            return response()->json(['message' => 'Department Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
      
    }

    public function edit($id)
    {
        try {
            return Department::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:departments,name,' . $id

        ]);
        try {
            $Department = Department::findOrFail($id);
            $Department->name = $request->name;
            $Department->updated_by = auth()->user()->id;
            $Department->save();
            return response()->json(['message' => 'Department Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {        
        try {
            Department::find($id)->delete();
            return response()->json(['message' => 'Department Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
