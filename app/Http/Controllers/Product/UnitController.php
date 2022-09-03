<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:units,name',
        ]);
        try {
            $Unit = new Unit();
            $Unit->name = $request->name;
            $Unit->created_by = auth()->user()->id;
            $Unit->save();
            return response()->json(['message' => 'Unit Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $Unit = Unit::orderBy('id', 'desc')->paginate($id);
            return response()->json($Unit);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return Unit::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:units,name,' . $id
        ]);
        try {
            $Unit = Unit::findOrFail($id);
            $Unit->name = $request->name;
            $Unit->updated_by = auth()->user()->id;
            $Unit->save();
            return response()->json(['message' => 'Unit Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function destroy($id)
    {
        try {
            Unit::find($id)->delete();
            return response()->json(['message' => 'Unit Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
