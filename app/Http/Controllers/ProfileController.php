<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class ProfileController extends Controller
{
    public function userProfile()
    {
        
        return Employee::with('relDesignation','relDepartment','relSocial','relTraining','relQualification')->where('id',auth()->user()->id)->first();
    }
   


}
