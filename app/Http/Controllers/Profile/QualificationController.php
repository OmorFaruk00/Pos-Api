<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Http\Controllers\Controller;



class QualificationController extends Controller
{
    function QualificationAdd(Request $request){
        $request->validate([
            'degree_name' => 'required',
            'institute_name' => 'required',
            'passing_year' => 'required|date-format:Y-m-d',
            'subject_name' => 'required',

        ]);

        $Qualification = new Qualification();
        $Qualification->degree_name = $request->degree_name;
        $Qualification->institute_name = $request->institute_name;
        $Qualification->passing_year = $request->passing_year;
        $Qualification->subject = $request->subject_name;
        $Qualification->employee_id = auth()->user()->id;  
        $Qualification->save();
        return response()->json(['message'=>'Qualification Added Successfully'],201);
    }


    
    function QualificationShow(){        
        return Qualification::where('employee_id',auth()->user()->id)->get();
        
        
        
    }
    function QualificationEdit($id){
        return Qualification::find($id);

    }
    function QualificationUpdate(Request $request,$id){
        $request->validate([
            'degree_name' => 'required',
            'institute_name' => 'required',
            'passing_year' => 'required|date-format:Y-m-d',
            'subject' => 'required',

        ]);

        $Qualification = Qualification::find($id);
        $Qualification->degree_name = $request->degree_name;
        $Qualification->institute_name = $request->institute_name;
        $Qualification->passing_year = $request->passing_year;
        $Qualification->subject = $request->subject;
        $Qualification->employee_id = auth()->user()->id;  
        $Qualification->save();
        return response()->json(['message' => 'Qualification Updated Successfully'],200);


    }   
    function QualificationDelete($id){              
        $Qualification = Qualification::find($id);     
        $Qualification->delete();
        return response()->json(['message' => 'Qualification Deleted Successfully'],200);
    }
        
        
        
    
}
