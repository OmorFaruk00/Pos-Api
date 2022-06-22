<?php

namespace App\Http\Controllers\DUM;

use Illuminate\Http\Request;
use App\Models\DUM\Facilitie;
use App\Http\Controllers\Controller;
class FacilitieController extends Controller
{
    function FacilitieAdd(Request $request){        
        $request->validate([
            'title' => 'required',
            'description' => 'required',           
            
        ]);
        $facilitie = new Facilitie();
        $facilitie->title = $request->title;
        $facilitie->description = $request->description;        
        $facilitie->status = 1;
        $facilitie->created_by = auth()->user()->name;
        $facilitie->save();
        return response()->json(['message' => 'Facilitie Added Successfully'],200);
    }


    
    function FacilitieShow(){
        return Facilitie::all();
        
        
    }
    function FacilitieEdit($id){
        return Facilitie::find($id);

    }
    function FacilitieUpdate(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'description' => 'required',           
            
        ]);
        $facilitie = facilitie::find($id);
        $facilitie->title = $request->title;
        $facilitie->description = $request->description;       
        $facilitie->status = 1;
        $facilitie->created_by = auth()->user()->name;
        $facilitie->save();
        return response()->json(['message' => 'Facilitie Updated Successfully'],200);

    }
    function FacilitieStatus($id){
        $facilitie = Facilitie::find($id);
        if($facilitie->status ==0){
            $facilitie->status = 1;
        }else{
            $facilitie->status = 0;
        }
        $facilitie->save();
        return response()->json(['message' => 'facilitie Status Change'],200);
    }
    function FacilitieDelete($id){
              
        $facilitie = Facilitie::find($id);
        $facilitie->delete();
        return response()->json(['message' => 'facilitie Deleted Successfully'],200);
    }
        
        
        
    
}
