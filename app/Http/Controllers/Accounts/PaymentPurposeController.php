<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\PaymentPurpose;
use App\Models\Accounts\SubFund;

class PaymentPurposeController extends Controller
{
    public function index()
    {
        return PaymentPurpose::with('relClass')->get();
    }
    public function store()
    {
        request()->validate([
            'name' => 'required|unique:payment_purposes,name',
            'amount' => 'required|numeric',
            'class_id' => 'required|numeric',
            'fund_id' => 'required|exists:funds,id',
            'sub_fund_id' => 'required|exists:sub_funds,id',
        ]);
        PaymentPurpose::make(request()->all());
        return response(['message'=>'Payment Purpose Make Successful']);
    }

    public function searchByClass($classId)
    {
        return PaymentPurpose::where('class_id',$classId)->get();
    }
}
