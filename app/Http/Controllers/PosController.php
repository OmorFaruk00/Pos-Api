<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PosService;
use App\Models\Sale;
use App\Models\Sale_detail;

class PosController extends Controller
{
    private $service;
    public function __construct(PosService $posService)
    {
        $this->service = $posService;
    }

    public function index(Request $request)
    {
        
   

    }
    public function createInvoice(Request $request)
    {

        $request->validate([
            "customer" => "required",
            "paid_amount" => "required",
        ]);

        try {
            return $this->service->createInvoiceService($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function salesList(Request $request)
    {
        try {
            return $this->service->selesList($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
       
    }
    public function salesInfo($id){
        $sales = Sale::with('customer','sale_details.product')->find($id);
        return response()->json($sales);

    }
    public function test(){
        return
        $this->service->testservice();

    }


}
