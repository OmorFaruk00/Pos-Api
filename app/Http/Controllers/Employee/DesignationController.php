<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    public function index()
    {
        try {
            $Designation = Designation::orderBy('id', 'desc')->paginate(8);
            return response()->json($Designation);
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
            'name' => 'required|unique:designations,name',
        ]);
        try {
            $Designation = new Designation();
            $Designation->name = $request->name;
            $Designation->created_by = auth()->user()->id;
            $Designation->save();
            return response()->json(['message' => 'Designation Added Successfully'], 201);
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
            return Designation::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:designations,name,' . $id

        ]);
        try {
            $Designation = Designation::findOrFail($id);
            $Designation->name = $request->name;
            $Designation->updated_by = auth()->user()->id;
            $Designation->save();
            return response()->json(['message' => 'Designation Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {        
        try {
            Designation::find($id)->delete();
            return response()->json(['message' => 'Designation Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
