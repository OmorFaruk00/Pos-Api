<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\Product_stock;
use App\Models\Customer;
use App\Models\Transection;


class PosService
{ 
    
  
    public function createInvoiceService($request){

        DB::transaction( function() use ($request) {
                
            $subtotal = $request->subtotal;
            $payable = $request->payable;
            $paid_amount = $request->paid_amount;
            $customer_id = $request->customer;

            $customer = Customer::find($customer_id);
            $previous_due = $customer->previous_due;            

            if($payable < $paid_amount){                    
              $paid = $paid_amount - $subtotal;
              $customer->previous_due = $previous_due - $paid;
              $customer->save();     

            }else{                    
                $paid = $subtotal - $paid_amount;
                $customer->previous_due = $previous_due + $paid;
                $customer->save();                    
            }
        
            $sale = new Sale();
            $sale->customer_id = $customer_id;
            $sale->vat = $request->vat;
            $sale->discount_amount = $request->discount;
            $sale->subtotal_amount  = $subtotal;
            $sale->payable_amount = $payable;
            $sale->paid_amount = $paid_amount;
            $sale->sale_date = Carbon::now();
            $sale->created_by = auth()->user()->id; 
            if($subtotal > $paid_amount){
                $due = ($subtotal - $request->discount) - $paid_amount;
                $sale->due_amount = $due;
            }              
            $sale->save();

            $transection = new Transection();
            $transection->amount = $paid_amount;
            $transection->transection_id = $sale->id;
            $transection->transection_type = 'Sales';
            $transection->created_by = auth()->user()->id;
            $transection->save();

            foreach ($request->cart as $key=>$val) {
                $report = new Sale_detail();
                $report->sale_id = $sale->id;
                $report->product_id = $val['id'];                    ;            
                $report->product_qty = $val['qty'];
                $report->product_price = $val['price'];
                $report->total_amount = $val['amount'];
                $report->save();    
                
                $stock = Product_stock::where('product_id',$val['id'])->first();
                $stock->available_quantity = $stock->available_quantity - $val['qty'];
                $stock->sold_quantity = $stock->sold_quantity + $val['qty'];
                $stock->save();

            }   
            
         });
        
         return response()->json(["message"=>"Sale Successfully"],200);
      

    }
    public function selesList($request){
        $search = $request->search;
        $list = $request->list;
        if ($search != null) {
            $sales =  Sale::select('id', 'customer_id', 'subtotal_amount', 'sale_date')
                ->with(['customer' => function ($q) {
                    $q->select('id', 'name', 'phone');
                }])
                ->whereHas('customer', function ($query) use ($search) {
                    $query->where('phone', 'like', '%' . $search . '%');
                    $query->orWhere('name', 'like', '%' . $search . '%');
                })->paginate($list);
            return response()->json($sales);
        } else {
            $sales = Sale::select('id', 'customer_id', 'subtotal_amount', 'sale_date')
                ->with(['customer' => function ($query) {
                    $query->select('id', 'name', 'phone');
                }])
                ->orderBy('id', "desc")->paginate($list);
                return response()->json($sales);
        }
    }

    public function testservice(){
        return 'service';

    }
  
}
