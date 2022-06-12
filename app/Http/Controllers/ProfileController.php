<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class ProfileController extends Controller
{
    public function user()
    {
        return Employee::with('relDesignation','relDepartment','relSocial')->where('id',4)->first();
    }
    public function SocialAdd()

    {
        $data = request()->validate([
            '*.social_name' => 'required',
            '*.social_url' => 'required',
            
        ]);
        // foreach (request()->all() as $key => $value) {
        //    Social::create([
        //         'social_name' => $value['social_name'],
        //         'social_url' => $value['social_url'],
        //         'employee_id' => auth()->user()->id,
        //     ]);
            
        // }
        // return response()->json(['message' => 'Social Added Successfully'],200);
        
    }


}
