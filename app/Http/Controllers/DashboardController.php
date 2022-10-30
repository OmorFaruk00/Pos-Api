<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{Sale,Customer,Expense,Supplier};
    


class DashboardController extends Controller
{
    public function index(){
        $today = date('Y-m-d') ;  
        $sale = Sale::get();   
        $expense = Expense::get();   
        $data['today_sale'] = $sale->where('sale_date','=', $today)->sum('subtotal_amount');
        $data['total_sale'] = $sale->sum('subtotal_amount');
        $data['today_sale_due'] = $sale->where('sale_date','=', $today)->sum('due_amount');
        $data['total_sale_due'] = $sale->sum('due_amount');
        $data['total_sale_invoice'] = $sale->count('id');
        $data['today_expense'] = $expense->where('date','=', $today)->sum('amount');
        $data['total_expense'] = $expense->sum('amount');
        $data['total_customer'] = Customer::count('id');
        $data['total_supplier'] = Supplier::count('id');

        return response()->json($data);


    }
}
