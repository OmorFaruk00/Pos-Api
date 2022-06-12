<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Models\Social;
use App\Http\Controllers\Controller;



class SocialController extends Controller
{
    function SocialAdd(Request $request){
        $request->validate([
            'social_name' => 'required',
            'social_url' => 'required',           
        ]);

        $Social = new Social();
        $Social->social_name = $request->social_name;
        $Social->social_url = $request->social_url;        
        $Social->employee_id = auth()->user()->id;  
        $Social->save();
        return response()->json(['message'=>'Social Added Successfully'],201);
    }


    
    function SocialShow(){
        return Social::where('employee_id',auth()->user()->id)->get();
        
        
    }
    function SocialEdit($id){
        return Social::find($id);

    }
    function SocialUpdate(Request $request,$id){
        $request->validate([
            'social_name' => 'required',
            'social_url' => 'required',           
        ]);

        $Social = Social::find($id);
        $Social->social_name = $request->social_name;
        $Social->social_url = $request->social_url;        
        $Social->employee_id = auth()->user()->id;  
        $Social->save();
        return response()->json(['message' => 'Social Updated Successfully'],200);

    }   
    function SocialDelete($id){              
        $Social = Social::find($id);     
        $Social->delete();
        return response()->json(['message' => 'Social Deleted Successfully'],200);
    }
        
        
        
    
}
