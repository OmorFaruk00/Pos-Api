<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\ProductStock;
use App\Models\Customer;
use App\Models\Transection;
use App\Models\Product;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;

class PosRepository
{


    public function createInvoice($request)
    {

        DB::transaction(function () use ($request) {

            $subtotal = $request->subtotal;
            $payable = $request->payable;
            $paid_amount = $request->paid_amount;
            $discount = $request->discount;
            $customer_id = $request->customer;
            $vat = $request->vat;

            if ($customer_id != null) {
                $customer = Customer::find($customer_id);
                $previous_due = $customer->previous_due;

                if ($payable < $paid_amount) {
                    $paid = $paid_amount - $subtotal;
                    $customer->previous_due = $previous_due - $paid;
                    $customer->save();
                } else {
                    $paid = $subtotal - $paid_amount;
                    $customer->previous_due = $previous_due + $paid;
                    $customer->save();
                }
            }


            $data = [
                'customer_id' => $customer_id ?? 0,
                'vat' => $vat,
                'discount_amount' => $discount,
                'subtotal_amount'  => $subtotal,
                'payable_amount' => $payable,
                'paid_amount' => $paid_amount,
                'sale_date' => Carbon::now(),
                'created_by' => auth()->user()->id

            ];
            if ($subtotal > $paid_amount) {
                $data['due_amount'] = $subtotal - $paid_amount;
            }

            $sale_id = Sale::insertGetId($data);

            $transection = new Transection();
            $transection->transection_id = $sale_id;
            $transection->amount = $paid_amount;
            $transection->transection_type = 'Sales';
            $transection->user_id = $customer_id;
            $transection->created_by = auth()->user()->id;
            $transection->save();

            foreach ($request->cart as $key => $val) {
                $report = new Sale_detail();
                $report->sale_id = $sale_id;
                $report->product_id = $val['id'];;
                $report->product_qty = $val['qty'];
                $report->product_price = $val['price'];
                $report->total_amount = $val['amount'];
                $report->save();

                $stock = ProductStock::where('product_id', $val['id'])->first();
                $stock->available_quantity = $stock->available_quantity - $val['qty'];
                $stock->sold_quantity = $stock->sold_quantity + $val['qty'];
                $stock->save();
            }
        });

        return response()->json(["message" => "Sale Successfully Done"], 200);
    }
    public function selesList($request)
    {
        $search = $request->search;
        $list = $request->list;
        $date = $request->date;

        $sales = Sale::with('customer')
            ->when($date != null, function ($q) use ($date) {
                $q->where('sale_date', $date);
            })
            ->when($search != null, function ($q) use ($search) {
                $q->where('subtotal_amount', 'like', '%' . $search . '%')
                    ->orWhere('paid_amount', 'like', '%' . $search . '%')
                    ->orWhere('due_amount', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($list);

        $sales->transform(function ($sale) {
            return [
                'id' => $sale->id,
                'customer_name' => $sale->customer->name ?? 'Walk-in Customer',
                'sale_date' => $sale->sale_date,
                'total' => $sale->subtotal_amount,
                'paid' => $sale->paid_amount,
                'due' => $sale->due_amount,
            ];
        });

        return response()->json($sales);
    }
    public function selesReturnList($request)
    {
        $search = $request->search;
        $list = $request->list;
        $date = $request->date;

        $sales_return = SaleReturn::with('customer')
            ->when($date != null, function ($q) use ($date) {
                $q->where('return_date', $date);
            })
            ->when($search != null, function ($q) use ($search) {
                $q->where('subtotal', 'like', '%' . $search . '%')
                    ->orWhere('grand_total', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($list);


        $sales_return->transform(function ($data) {
            return [
                'id' => $data->id,
                'customer_name' => $data->customer->name ?? 'Walk-in Customer',
                'return_date' => $data->return_date,
                'total' => $data->grand_total,
            ];
        });

        return response()->json($sales_return);
    }

    public function ProductSelesInfo($id)
    {

        $sales = Sale::with('customer', 'sale_details.product')->find($id);
        return response()->json($sales);
    }


    public function getReturnProductItem($item)
    {
        $query = Product::where('product_name', 'like', '%' . $item . '%')
            ->orwhere(function ($q) use ($item) {
                $q->orWhere('product_code', 'like', '%' . $item . '%')
                    ->orWhere('barcode', 'like', '%' . $item . '%')
                    ->orWhere('sales_price', 'like', '%' . $item . '%');
            })
            ->orderBy('id','desc')
            ->get();

        $query->transform(function ($product, $key) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'code' => $product->product_code,
                'price' => $product->sales_price,
                'discount' => $product->discount,
            ];
        });
        if (count($query) > 0) {
            return response()->json($query);
        } else {
            return response()->json(['message' => 'Product Not Found', 'status' => 404]);
        }
    }

    public function ReturnProductStore($request)
    {

        DB::transaction(function () use ($request) {

            $product = new SaleReturn();
            $product->customer_id = $request->customer_id ?? 0;
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
            $transection->user_id = $request->customer_id ?? 0;
            $transection->transection_type = 'Sales Return';
            $transection->created_by = auth()->user()->id;
            $transection->save();

            foreach ($request->product as $key => $val) {
                $detail = new SaleReturnDetail();
                $detail->sale_return_id = $product->id;
                $detail->product_id = $val['id'];;
                $detail->name = $val['name'];
                $detail->code = $val['code'];
                $detail->qty = $val['qty'];
                $detail->price = $val['price'];
                $detail->amount = $val['amount'];
                $detail->discount = $val['discount'];
                $detail->save();

                $stock = ProductStock::where('product_id', $val['id'])->first();
                $stock->available_quantity = $stock->available_quantity + $val['qty'];
                $stock->save();
            }
        });

        return response()->json(['message' => 'Sales Return Done']);
    }
    public function ProductReturnInfo($id)
    {

        $data = SaleReturn::with('customer', 'return_info')->find($id);
        return response()->json($data);
    }
}
