<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\StudentCost;
use App\Models\Accounts\Transaction;
use App\Models\Student;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::all();
    }

}
