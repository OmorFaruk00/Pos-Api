<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ReturnProduct,Sale,Expense};


class ReportController extends Controller
{
    public function SalesReport(Request $request){
        $from = $request->start_date;
        $to = $request->end_date;
        $report =  Sale::with('customer')->whereBetween('sale_date', [$from, $to])->get();      
 
      $data['reports'] = $report->map(function ($rept){
        return [
            'id'=>$rept->id,
            'customer_name'=>$rept->customer->name ?? 'Walk-in Customer',                
            'sale_date'=>$rept->sale_date,
            'total'=>$rept->subtotal_amount,                
            'paid'=>$rept->paid_amount,                
            'due'=>$rept->due_amount,            
           ];
       });
      $data['grand_total'] = $report->sum('subtotal_amount');
      $data['total_paid'] = $report->sum('paid_amount');
      $data['total_due'] = $report->sum('due_amount');
        return response()->json($data);
    }
    public function SalesReturnReport(Request $request){
        $from = $request->start_date;
        $to = $request->end_date;
        $report =  ReturnProduct::with('customer')->whereBetween('return_date', [$from, $to])->get();      
 
      $data['reports'] = $report->map(function ($rept){
        return [
            'id'=>$rept->id,
            'customer_name'=>$rept->customer->name ?? 'Walk-in Customer',                
            'return_date'=>$rept->return_date,
            'qty'=>$rept->total_qty,                
            'total'=>$rept->grand_total,                
           
           ];
       });
      $data['grand_total'] = $report->sum('grand_total');
      $data['total_qty'] = $report->sum('total_qty');
    
        return response()->json($data);
    }
    public function ExpenseReport(Request $request){
        $from = $request->start_date;
        $to = $request->end_date;
        $category = $request->category;

        $report =  Expense::with('category')
        ->whereBetween('date', [$from, $to])
        ->when($category !=null, function($q) use($from,$to,$category){
            $q->whereBetween('date', [$from, $to])
            ->WhereHas('category', function($q) use($category){
                $q->where('id', $category);
            });
        })
        
       ->get();      
 
      $data['reports'] = $report->map(function ($rept){
        return [
            'id'=>$rept->id,
            'date'=>$rept->date,                
            'category_name'=>$rept->category->name,                
            'purpose'=>$rept->purpose,
            'description'=>$rept->description,                
            'amount'=>$rept->amount,                
           
           ];
       });
      $data['total_amount'] = $report->sum('amount');
      
    
        return response()->json($data);
    }





    
}
