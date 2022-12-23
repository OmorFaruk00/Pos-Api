<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\PurchaseRepository;

class PurchaseControlller extends Controller
{
    private $repository;
    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->repository = $purchaseRepository;
    }
    public function PurchaseInvoice(Request $request){
        try {
            return $this->repository->PurchaseInvoiceCreate($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function PurchaseList(Request $request){
        try {
            return $this->repository->PurchaseListShow($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function PurchaseInfo($id){
        try {
            return $this->repository->PurchaseInfoShow($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
