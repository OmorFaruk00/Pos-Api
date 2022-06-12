<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Http\Controllers\Controller;



class TrainingController extends Controller
{
    function TrainingAdd(Request $request){
        $request->validate([
            'training_name' => 'required',
            'institute_name' => 'required',
            'training_year' => 'required|date-format:Y-m-d',
            'duration' => 'required',

        ]);

        $Training = new Training();
        $Training->training_name = $request->training_name;
        $Training->institute_name = $request->institute_name;
        $Training->training_year = $request->training_year;
        $Training->duration = $request->duration;
        $Training->employee_id = auth()->user()->id;  
        $Training->save();
        return response()->json(['message'=>'Training Added Successfully'],201);
    }


    
    function TrainingShow(){        
        return Training::where('employee_id',auth()->user()->id)->get();
        
        
        
    }
    function TrainingEdit($id){
        return Training::find($id);

    }
    function TrainingUpdate(Request $request,$id){
        $request->validate([
            'training_name' => 'required',
            'institute_name' => 'required',
            'training_year' => 'required|date-format:Y-m-d',
            'duration' => 'required',

        ]);

        $Training = Training::find($id);
        $Training->training_name = $request->training_name;
        $Training->institute_name = $request->institute_name;
        $Training->training_year = $request->training_year;
        $Training->duration = $request->duration;
        $Training->employee_id = auth()->user()->id;  
        $Training->save();
        return response()->json(['message' => 'Training Updated Successfully'],200);


    }   
    function TrainingDelete($id){              
        $Training = Training::find($id);     
        $Training->delete();
        return response()->json(['message' => 'Training Deleted Successfully'],200);
    }
        
        
        
    
}
