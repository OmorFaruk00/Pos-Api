<?php

namespace App\Http\Services;

use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\Product_stock;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;


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
              $$paid = $paid_amount - $subtotal;
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
            $sale->save();
            foreach ($request->cart as $key=>$val) {
                $report = new Sale_detail();
                $report->Sale_id = $sale->id;
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
        
        //  $invoice = Sale::with('customer','sale_details')->latest('id')->first();
        //  $pdf = PDF::loadView('sale-invoice', compact('invoice'));
        //  return $pdf->stream('invoice.pdf');
         return response()->json(["message"=>"Sale Successfully"],200);
      

    }
  
}
