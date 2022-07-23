<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\Classes;
use App\Models\Accounts\PaymentPurpose;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        return Classes::get();
    }
    public function store()
    {
        request()->validate([
            'name' => 'required|unique:classes,name',
            'admissionFee' => 'required|numeric',
            'monthlyFee' => 'required|numeric',
        ]);
        Classes::make(request()->all());
        return response(['message'=>'Class Make Successful']);
    }
}
