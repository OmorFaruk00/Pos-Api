<?php

namespace App\Http\Repository;
use Illuminate\Support\Facades\DB;
use App\Models\{ReturnProduct,Sale,Sale_detail,Expense,Product,ProductStock};



class ReportRepository
{
    public function GetSalesReport($request){
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
    public function GetSalesReturnReport($request){
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
    public function GetExpenseReport($request){
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
    public function GetStockReport($request){
            
        $brand = $request->brand;
        $category = $request->category;

        $report = Product::with('relBrand','relCategory','stock')     
        ->when($brand !=null, function ($q) use ($brand) {
             $q->where('brand',$brand);
        })
        ->when($category !=null, function ($q) use ($category) {
             $q->where('category',$category);
        })      
        ->orderBy('id', 'desc')            
        ->get();         
 
      $data['reports'] = $report->map(function ($rept){
        return [
            'product_code'=>$rept->product_code,
            'product_name'=>$rept->product_name,
            'brand'=>$rept->relBrand->name,                
            'category'=>$rept->relCategory->name,                     
            'unit_price'=>$rept->purchase_price,
            'sales_price'=>$rept->sales_price,
            'current_stock'=>$rept->stock->available_quantity ?? 0,                
            'stock_value'=>$rept->stock->available_quantity * $rept->purchase_price,
                         
           ];
       });
       
      $data['total_unit_price'] = $report->sum('purchase_price');
      $data['total_sales_price'] = $report->sum('sales_price');
      $data['total_stock'] = $report->sum('stock.available_quantity');      
      $data['total_stock_value'] = $report->sum(function ($s){
        return $s->purchase_price * $s->stock->available_quantity;
      });
        return response()->json($data);

    }

    public function GetProfitLossReport($request){
        $from = $request->start_date;
        $to = $request->end_date;
  
       $report = Sale_detail::with('product')->whereBetween('created_at', [$from, $to])->select('product_id', DB::raw('count(product_id)as total_qty'))
        ->groupBy('product_id')    
        ->get();

        $report->transform(function ($data){
            $discount = $data->total_qty *(($data->product->sales_price * $data->product->discount) / 100);
            $price = $data->product->sales_price * $data->total_qty;
            $sales_price = $price - $discount ;
            $purchase_price = $data->product->purchase_price * $data->total_qty ;
            $gross_profit = $sales_price - $purchase_price;
            
            return[
                'product_name'=>$data->product->product_name,
                'sale_qty'=>$data->total_qty,
                'sales_price'=>$sales_price,               
                'purchase_price'=>$purchase_price,
                'gross_profit'=>$gross_profit,

            ];
        });

        return response()->json(["data" => $report], 200);
    }
    
}
