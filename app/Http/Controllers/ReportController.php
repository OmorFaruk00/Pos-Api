<?php

namespace App\Http\Controllers;

use App\Http\Repository\ReportRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $repository;
    public function __construct(ReportRepository $reportRepository)
    {
        $this->repository = $reportRepository;

    }
    public function SalesReport(Request $request)
    {
        try {
            return $this->repository->GetSalesReport($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    public function SalesReturnReport(Request $request)
    {
        try {
            return $this->repository->GetSalesReturnReport($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    public function ExpenseReport(Request $request)
    {
        try {
            return $this->repository->GetExpenseReport($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    public function StockReport(Request $request)
    {
        try {
            return $this->repository->GetStockReport($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function ProfitLossReport(Request $request)
    {
        try {
            return $this->repository->GetProfitLossReport($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
