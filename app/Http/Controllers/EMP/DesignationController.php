<?php

namespace App\Http\Controllers\EMP;

use Illuminate\Http\Request;
use App\Models\EMP\Designation;
use App\Http\Controllers\Controller;



class DesignationController extends Controller
{
    function DesignationAdd(Request $request){
        $request->validate([
            'designation' => 'required',
            'type' => 'required',           
        ]);

        $Designation = new Designation();
        $Designation->type = $request->type;
        $Designation->designation = $request->designation;
        $Designation->status = 1;
        $Designation->created_by = auth()->user()->name;  
        $Designation->save();
        return response()->json(['message'=>'Designation Added Successfully'],201);
    }


    
    function DesignationShow(){
        return Designation::all();
        
        
    }
    function DesignationEdit($id){
        return Designation::find($id);

    }
    function DesignationUpdate(Request $request,$id){
        $request->validate([
            'designation' => 'required',
            'type' => 'required',           
        ]);

        $Designation = Designation::find($id);
        $Designation->type = $request->type;
        $Designation->designation = $request->designation;        
        $Designation->created_by = auth()->user()->name;  
        $Designation->save();
        return response()->json(['message' => 'Designation Updated Successfully'],200);

    }
    function DesignationStatus($id){
        // return $slug;
        $Designation = Designation::find($id);
        if($Designation->status == 0){
            $Designation->status = 1;
        }else{
            $Designation->status = 0;
        }
        $Designation->save();
        return response()->json(['message' => 'Designation Status Change'],200);
    }
    function DesignationDelete($id){              
        $Designation = Designation::find($id);     
        $Designation->delete();
        return response()->json(['message' => 'Designation Deleted Successfully'],200);
    }
        
        
        
    
}
