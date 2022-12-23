<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Models\Transection;
use App\Models\Product;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;

class PurchaseRepository
{ 
    
  
    public function PurchaseInvoiceCreate($request){     

        DB::transaction( function() use ($request) {
                
            $subtotal = $request->subtotal;
            $payable = $request->payable;
            $paid_amount = $request->paid_amount;
            $discount = $request->discount;
            $supplier_id = $request->supplier;      
            $vat = $request->vat;

            if($supplier_id != null){
                $supplier = Supplier::find($supplier_id);
                $previous_due = $supplier->previous_due;            
    
                if($payable < $paid_amount){                    
                  $paid = $paid_amount - $subtotal;
                  $supplier->previous_due = $previous_due - $paid;
                  $supplier->save();     
    
                }else{                    
                    $paid = $subtotal - $paid_amount;
                    $supplier->previous_due = $previous_due + $paid;
                    $supplier->save();                    
                }
            } 
        
        
        $data = [
            'supplier_id' => $supplier_id,
            'vat' => $vat,
            'discount_amount' => $discount,
            'subtotal_amount'  => $subtotal,
            'payable_amount' => $payable,
            'paid_amount' => $paid_amount,
            'purchase_date' => Carbon::now(),
            'created_by' => auth()->user()->id
            
        ];
        if($subtotal > $paid_amount){           
            $data['due_amount'] = $subtotal-$paid_amount;
        }

        $purchase_id =Purchase::insertGetId($data);       
        
            $transection = new Transection();
            $transection->transection_id = $purchase_id;
            $transection->amount = $paid_amount;
            $transection->transection_type = 'purchases';
            $transection->user_id = $supplier_id;
            $transection->created_by = auth()->user()->id;
            $transection->save();

            foreach ($request->cart as $key=>$val) {
                $report = new PurchaseDetail();
                $report->purchase_id = $purchase_id;
                $report->product_id = $val['id'];                    ;            
                $report->product_qty = $val['qty'];
                $report->product_price = $val['price'];
                $report->total_amount = $val['amount'];
                $report->save();    
                
                $stock = ProductStock::where('product_id',$val['id'])->first();
                $stock->available_quantity = $stock->available_quantity + $val['qty'];
                $stock->purchase_quantity = $stock->purchase_quantity + $val['qty'];
                $stock->save();

            }   
            
         });        
        
         return response()->json(["message"=>"Purchase Successfully Done"],200);
      

    }
    public function PurchaseListShow($request){        
        $search = $request->search;
        $list = $request->list;
        $date = $request->date;

        $purchases = Purchase::with('supplier')
        ->when($date !=null, function ($q) use ($date) {
            $q->where('purchase_date',$date);
        })       
        ->when($search !=null, function ($q) use ($search) {  
            $q->where('subtotal_amount', 'like', '%'.$search.'%')           
            ->orWhere('paid_amount', 'like', '%'.$search.'%')
            ->orWhere('due_amount', 'like', '%'.$search.'%')            
            ->orWhereHas('supplier', function( $query ) use ( $search ){
                $query->where('name', 'like', '%'.$search.'%');
            });         
                       
        })
        ->orderBy('id', 'desc')                
        ->paginate($list); 

        $purchases->transform(function($purchase) {
            return[
                'id'=>$purchase->id,
                'supplier_name'=>$purchase->supplier->name,                
                'purchase_date'=>$purchase->purchase_date,
                'total'=>$purchase->subtotal_amount,                
                'paid'=>$purchase->paid_amount,                
                'due'=>$purchase->due_amount,                
            ];
        });
        
        return response()->json($purchases);
       
    }
    public function PurchaseInfoShow($id){      
        
        $purchases = Purchase::with('supplier','purchase_details.product')->find($id);
        return response()->json($purchases);

    }
    public function selesReturnList($request){
        $search = $request->search;
        $list = $request->list;
        $date = $request->date;

        $purchases_return = PurchaseReturn::with('supplier')
        ->when($date !=null, function ($q) use ($date) {
            $q->where('return_date',$date);
        })  
        ->when($search !=null, function ($q) use ($search) {  
            $q->where('subtotal', 'like', '%'.$search.'%')           
            ->orWhere('grand_total', 'like', '%'.$search.'%')
            ->orWhereHas('supplier', function( $query ) use ( $search ){
                $query->where('name', 'like', '%'.$search.'%');
            });                              
                       
        })
        ->orderBy('id', 'desc')        
        ->paginate($list);                   

       
        $purchases_return->transform(function($data) {
            return[
                'id'=>$data->id,
                'supplier_name'=>$data->supplier->name ?? 'Walk-in supplier',                
                'return_date'=>$data->return_date,                
                'total'=>$data->grand_total,                
            ];  

        });
        
        return response()->json($purchases_return);
       
    }
   
  
 

    public function getReturnProductItem($item){
        $query = Product::where('product_name', 'like', '%'.$item.'%')            
        ->orwhere( function ($q) use ($item) { 
                 $q->orWhere('product_code', 'like', '%'.$item.'%')
                 ->orWhere('barcode', 'like', '%'.$item.'%')
                 ->orWhere('purchases_price', 'like', '%'.$item.'%');                    
         })                                    
         ->get(); 

            $query->transform(function($product, $key) {
            return [
            'id' => $product->id,
            'name' => $product->product_name,
            'code' => $product->product_code,               
            'price' => $product->purchases_price, 
            'discount' => $product->discount, 
            ];
            });
            if(count($query)>0){
                return response()->json($query); 

            }else{
                return response()->json(['message' => 'Product Not Found', 'status'=>404]);
            }
            
   }

   public function ReturnProductStore($request){

    DB::transaction( function() use ($request) {               
        
        $product = new PurchaseReturn();
        $product->supplier_id = $request->supplier_id ?? 0;
        $product->total_qty = $request->total_qty;
        $product->subtotal = $request->subtotal;
        $product->discount = $request->discount;
        $product->grand_total = $request->grand_total;
        $product->note = $request->note ?? null;
        $product->return_date = Carbon::now();
        $product->created_by = auth()->user()->id;                   
        $product->save();

        $transection = new Transection();
        $transection->amount =  $request->grand_total;
        $transection->transection_id = $product->id;
        $transection->user_id = $request->supplier_id ?? 0;
        $transection->transection_type = 'purchases Return';
        $transection->created_by = auth()->user()->id;
        $transection->save();

        foreach ($request->product as $key=>$val) {
            $detail = new purchaseReturnDetail();
            $detail->purchase_return_id = $product->id;
            $detail->product_id = $val['id'];                    ;            
            $detail->name = $val['name'];
            $detail->code = $val['code'];
            $detail->qty = $val['qty'];
            $detail->price = $val['price'];
            $detail->amount = $val['amount'];
            $detail->discount = $val['discount'];
            $detail->save();    
            
            $stock = ProductStock::where('product_id',$val['id'])->first();
            $stock->available_quantity = $stock->available_quantity + $val['qty'];           
            $stock->save();
        }
    }); 
    
    return response()->json(['message'=> 'Product Return Done']);
   }
   public function ProductReturnInfo($id){
        
    $data = purchaseReturn::with('supplier','return_info')->find($id);
    return response()->json($data);

}
  
}