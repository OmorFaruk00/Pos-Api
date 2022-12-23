<?php

namespace App\Http\Repository;

use App\Models\Supplier;

class SupplierRepository
{

    public function getSupplier()
    {
        $result = Supplier::select('id', 'name', 'previous_due')->get();
        return response()->json($result);
    }
    public function storeSupplier($validatedData)
    {
        $validatedData['created_by'] = auth()->user()->id;
        Supplier::insert($validatedData);
        return response()->json(['message' => 'Supplier Added Successfully'], 201);
    }

    public function editSupplier($id)
    {
        $result = Supplier::findOrFail($id);
        return response()->json($result);
    }

    public function updateSupplier($validatedData, $id)
    {

        $Supplier = Supplier::findOrFail($id);
        $validatedData['updated_by'] = auth()->user()->id;
        $Supplier->update($validatedData);
        return response()->json(['message' => 'Supplier Updated Successfully'], 201);
    }
    public function SupplierListBySearch($request)
    {
        $search = $request->search;
        $list = $request->list;

        $supplier = Supplier::when($search != null, function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate($list);
        return response()->json($supplier);
    }
    public function deleteSupplier($id)
    {
        Supplier::findOrFail($id)->delete();
        return response()->json(['message' => 'Supplier Delete Successfully'], 201);
    }
}
