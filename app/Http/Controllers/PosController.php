<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PosService;

class PosController extends Controller
{
    private $service;
    public function __construct(PosService $posService)
    {
        $this->service = $posService;
    }

    public function index(Request $request){
        // $invoice = Sale::with('customer','sale_details')->find(1);
        // $pdf = PDF::loadView('sale-invoice', compact('invoice'));
        // return $pdf->stream('invoice.pdf');

    }
    public function createInvoice(Request $request){     
        
        $request->validate([
            "customer" => "required",
            "paid_amount" => "required",
        ]);    
           
        try {          
            return $this->service->createInvoiceService($request);   
           
        }  catch (\Exception $e) {
            return $e->getMessage();
        }        

    }
}
