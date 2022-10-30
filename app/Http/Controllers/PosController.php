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

   
    public function createInvoice(Request $request)
    {
        $request->validate([            
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
      
        try {
            return $this->service->ProductSelesInfo($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

    }
    public function salesReturn(Request $request){
      
        try {
            return $this->service->selesReturnList($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

    }
    public function salesReturnInfo($id){
      
        try {
            return $this->service->ProductReturnInfo($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

    }
    public function ReturnProduct($item){ 
        try {
            return $this->service->getReturnProductItem($item);
        } catch (\Exception $e) {
            return $e->getMessage();
        }   
    }
    public function ReturnProductSubmit(Request $request){
        try {
            return $this->service->ReturnProductStore($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
    }
    public function Return(Request $request){
        try {
            return 'data';
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
    }


}