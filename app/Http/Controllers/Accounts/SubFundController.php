<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\SubFund;

class SubFundController extends Controller
{
    public function index()
    {
        return SubFund::with('relFund')->get();
    }
    public function store()
    {
        request()->validate([
            'name'=>'required|unique:sub_funds,name',
            'fund_id'=>'required|exists:funds,id',
            'total'=> 'required|numeric'
        ]);
        SubFund::makeSubFund(request()->all());
        return response(['message'=>'Sub Fund Make Successful']);
    }


}
