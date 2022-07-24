<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\Fund;
use App\Models\Accounts\SubFund;

class FundController extends Controller
{
    public function index()
    {
        return Fund::all();
    }
    public function store()
    {
        request()->validate([
           'name'=>'required|unique:funds,name',
           'total'=> 'required|numeric'
        ]);
        Fund::makeFund(request()->all());
        return response(['message'=>'Fund Make Successful']);
    }
    public function getSubFunds($id){
        return SubFund::where('fund_id',$id)->get();
    }
}
