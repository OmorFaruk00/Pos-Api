<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function SupplierList(Request $request)
    {
        try {            
            $search = $request->search;
            $list = $request->list;            
    
            $Supplier = Supplier::
            when($search !=null, function ($q) use ($search) {  
                $q->where('name', 'like', '%'.$search.'%')           
                ->orWhere('phone', 'like', '%'.$search.'%');                           
            })
            ->orderBy('id', 'desc')                
            ->paginate($list);
            return response()->json($Supplier);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function index()
    {
        try {                   
            $result = Supplier::select('id','name')->get();
            return response()->json($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {    
        $data  = $this->validate($request,
        [
            'name' => 'required',           
            'phone' => 'required',           
            'email' => 'nullable',           
            'opening_balance'   => 'nullable',
            'address'   => 'nullable',
        ]);     
        
        try {
            $data['created_by'] = auth()->user()->id;           
            $result = Supplier::create($data);
            return response()->json(['message' => 'Supplier Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($list)
    {
       
    }

    public function edit($id)
    {
        try {
            return Supplier::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request,
        [
            'name' => 'required',           
            'phone' => 'required',           
            'email' => 'nullable',           
            'opening_balance'   => 'nullable',
            'address'   => 'nullable',
        ]);

        try {
            $Supplier = Supplier::findOrFail($id);           
            $Supplier->update($data);           
            return response()->json(['message' => 'Supplier Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
       
        try {
            $data = Supplier::find($id)->delete();           
            return response()->json(['message' => 'Supplier Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
