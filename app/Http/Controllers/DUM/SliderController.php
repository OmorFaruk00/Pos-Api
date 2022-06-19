<?php

namespace App\Http\Controllers\DUM;

use Illuminate\Http\Request;
use App\Models\DUM\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class SliderController extends Controller
{
    function SliderAdd(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required',            
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',           
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');        

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);                      
        }
        $Slider = new Slider();
        $Slider->title = $request->title;
        $Slider->description = $request->description;        
        $Slider->image = $file_name;
        $Slider->status = 1;
        $Slider->created_by = auth()->user()->id;        
        $Slider->save();
        return response()->json(['message' => 'Slider Added Successfully'],200);
    }


    
    function SliderShow(){
        return Slider::all();
        
        
    }
    function SliderEdit($id){
        return Slider::find($id);

    }
    function SliderUpdate(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'description' => 'required', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',           
            
        ]);
        $Slider = Slider::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');       

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);            
            unlink(public_path() .'/images/dum/'. $Slider->image);          
        }
        
        $Slider->title = $request->title;
        $Slider->description = $request->description;     
        $Slider->image = $file_name??$Slider->image;
        $Slider->status = 1;
        $Slider->created_by = auth()->user()->id;        
        $Slider->save();
        return response()->json(['message' => 'Slider Updated Successfully'],200);

    }
    function SliderStatus($id,$status){
        $Slider = Slider::find($id);
        if($Slider->status ==0){
            $Slider->status = 1;
        }else{
            $Slider->status = 0;
        }
        $Slider->save();
        return response()->json(['message' => 'Slider Status Change'],200);
    }
    function SliderDelete($id){              
        $Slider = Slider::find($id);        
        unlink(public_path() .'/images/dum/'. $Slider->image);
        $Slider->delete();
        return response()->json(['message' => 'Slider Deleted Successfully'],200);
    }
        
        
        
    
}
