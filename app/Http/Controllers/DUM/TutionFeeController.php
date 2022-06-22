<?php

namespace App\Http\Controllers\DUM;

use Illuminate\Http\Request;
use App\Models\DUM\TutionFee;
use App\Http\Controllers\Controller;
class TutionFeeController extends Controller
{
    function TutionFeeAdd(Request $request){        
        $request->validate([
            'name_of_program' => 'required',
            'type' => 'required',
            'duration' => 'required',
            'total_fee' => 'required|numeric',


            
        ]);
        $tutionfee = new TutionFee();
        $tutionfee->name_of_program = $request->name_of_program;
        $tutionfee->duration = $request->duration;  
        $tutionfee->type = $request->type;  
        $tutionfee->total_fee = $request->total_fee;
        $tutionfee->status = 1;
        $tutionfee->created_by = auth()->user()->id;
        $tutionfee->save();
        return response()->json(['message' => 'TutionFee Added Successfully'],200);
    }


    
    function TutionFeeShow(){
        return TutionFee::all();
        
        
    }
    function TutionFeeEdit($id){
        return TutionFee::find($id);

    }
    function TutionFeeUpdate(Request $request,$id){
        $request->validate([
            'name_of_program' => 'required',
            'type' => 'required',
            'duration' => 'required',
            'total_fee' => 'required|numeric',


            
        ]);
        $tutionfee = TutionFee::find($id);
        $tutionfee->name_of_program = $request->name_of_program;
        $tutionfee->duration = $request->duration;  
        $tutionfee->type = $request->type;  
        $tutionfee->total_fee = $request->total_fee;
        $tutionfee->status = 1;
        $tutionfee->created_by = auth()->user()->id;
        $tutionfee->save();
        return response()->json(['message' => 'TutionFee Updated Successfully'],200);

    }
    function TutionFeeStatus($id){
        $tutionfee = TutionFee::find($id);
        if($tutionfee->status ==0){
            $tutionfee->status = 1;
        }else{
            $tutionfee->status = 0;
        }
        $tutionfee->save();
        return response()->json(['message' => 'tutionfee Status Change'],200);
    }
    function TutionFeeDelete($id){
              
        $tutionfee = TutionFee::find($id);
        $tutionfee->delete();
        return response()->json(['message' => 'tutionfee Deleted Successfully'],200);
    }
        
        
        
    
}
 