<?php

namespace App\Http\Controllers\DUM;

use Illuminate\Http\Request;
use App\Models\DUM\Program;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class ProgramController extends Controller
{
    function ProgramAdd(Request $request){
        $request->validate([
            'title' => 'required',           
            'slug' => 'required|unique:programs',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
             
                       
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
        

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
            $image_url = env('APP_URL') . "/images/dum/$file_name";            
        }
        $Program = new Program();
        $Program->title = $request->title;        
        $Program->slug = $request->slug;
        $Program->image = $file_name;
        $Program->status = 1;
        $Program->created_by = auth()->user()->name;        
        $Program->save();
        return response()->json(['message' => 'Program Added Successfully'],200);
    }


    
    function ProgramShow(){
        return Program::all();
        
        
    }
    function ProgramEdit($id){
        return Program::find($id);

    }
    function ProgramUpdate(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',                       
            
        ]);
        $Program = Program::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');       

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
            $image_url = env('APP_URL') . "/images/dum/$file_name"; 
            unlink(public_path() .'/images/dum/'. $Program->image);          
        }
        
        $Program->title = $request->title;           
        $Program->image = $file_name??$Program->image;
        $Program->status = 1;
        $Program->created_by = auth()->user()->name;        
        $Program->save();
        return response()->json(['message' => 'Program Updated Successfully'],200);

    }
    function ProgramStatus($id,$status){
        $Program = Program::find($id);
        if($Program->status ==0){
            $Program->status = 1;
        }else{
            $Program->status = 0;
        }
        $Program->save();
        return response()->json(['message' => 'Program Status Change'],200);
    }
    function ProgramDelete($id){              
        $Program = Program::find($id);        
        unlink(public_path() .'/images/dum/'. $Program->image);
        $Program->delete();
        return response()->json(['message' => 'Program Deleted Successfully'],200);
    }
        
        
        
    
}
