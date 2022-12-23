<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\PosRepository;


class PosController extends Controller
{
    private $repository;
    public function __construct(PosRepository $posRepository)
    {
        $this->repository = $posRepository;
    }

   
    public function createInvoice(Request $request)
    {
        $request->validate([            
            "paid_amount" => "required",
        ]);

        try {
            return $this->repository->createInvoice($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function salesList(Request $request)
    {
        try {
            return $this->repository->selesList($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }        
       
    }
    public function salesInfo($id){
      
        try {
            return $this->repository->ProductSelesInfo($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

    }
    public function salesReturn(Request $request){
      
        try {
            return $this->repository->selesReturnList($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

    }
    public function salesReturnInfo($id){
      
        try {
            return $this->repository->ProductReturnInfo($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

    }
    public function ReturnProduct($item){ 
        try {
            return $this->repository->getReturnProductItem($item);
        } catch (\Exception $e) {
            return $e->getMessage();
        }   
    }
    public function ReturnProductSubmit(Request $request){
        try {
            return $this->repository->ReturnProductStore($request);
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