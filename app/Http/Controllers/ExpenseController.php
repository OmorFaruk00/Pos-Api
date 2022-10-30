<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function ExpenseList(Request $request)
    {
        try {            
            $search = $request->search;
            $list = $request->list;
            $date = $request->date;
    
            $expense = Expense::with('category')
            ->when($date !=null, function ($q) use ($date) {
                $q->where('date',$date);
            })       
            ->when($search !=null, function ($q) use ($search) {  
                $q->where('purpose', 'like', '%'.$search.'%')           
                ->orWhere('amount', 'like', '%'.$search.'%')
                ->orWhereHas('category', function( $query ) use ( $search ){
                    $query->where('name', 'like', '%'.$search.'%');
                });
                
                       
                           
            })
            ->orderBy('id', 'desc')                
            ->paginate($list); 
    
            $expense->transform(function($expense) {
                return[
                    'id'=>$expense->id,
                    'date'=>$expense->date,                
                    'category'=>$expense->category->name,                
                    'date'=>$expense->date,                
                    'purpose'=>$expense->purpose,
                    'amount'=>$expense->amount,
                    'description'=>$expense->description
                                 
                ];
            });


            return response()->json($expense);

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
            'category_id' => 'required',           
            'amount' => 'required',           
            'purpose' => 'required',           
            'description'   => 'nullable',
        ],
        [
            'category_id.required'     => ' The Category field is required.',           
        ]      
        );
        
        try {
            $data['created_by'] = auth()->user()->id;
            $data['date'] = Carbon::now();
            $result = Expense::create($data);
            return response()->json(['message' => 'Expense Added Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($list)
    {
        try {            
            $Expense = Expense::orderBy('id', 'desc')->paginate($list);
            return response()->json($Expense);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            return Expense::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request,
        [
            'category_id' => 'required',           
            'amount' => 'required',           
            'purpose' => 'required',           
            'description'   => 'nullable',
        ],
        [
            'Expense_id.required'     => ' Expense field is required.',           
        ]      
        );

        try {
            $Expense = Expense::findOrFail($id);           
            $Expense->update($data);           
            return response()->json(['message' => 'Expense Updated Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
       
        try {
            $data = Expense::find($id)->delete();           
            return response()->json(['message' => 'Expense Delete Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
