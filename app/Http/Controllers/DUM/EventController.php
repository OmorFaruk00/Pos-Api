<?php

namespace App\Http\Controllers\DUM;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DUM\Event;

class EventController extends Controller
{
    function EventAdd(Request $request){
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
        $Event = new Event();
        $Event->title = $request->title;
        $Event->description = $request->description;        
        $Event->image = $file_name;
        $Event->status = 1;
        $Event->created_by = auth()->user()->id;        
        $Event->save();
        return response()->json(['message' => 'Event Added Successfully'],200);
    }


    
    function EventShow(){
        return Event::all();
        
        
    }
    function EventEdit($id){
        return Event::find($id);

    }
    function EventUpdate(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'description' => 'required', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',         
            
        ]);
        $Event = Event::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');       

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);           
            unlink(public_path() .'/images/dum/'. $Event->image);          
        }
        
        $Event->title = $request->title;
        $Event->description = $request->description;     
        $Event->image = $file_name??$Event->image;
        $Event->status = 1;
        $Event->created_by = auth()->user()->name;        
        $Event->save();
        return response()->json(['message' => 'Event Updated Successfully'],200);

    }
    function EventStatus($id){
        $Event = Event::find($id);
        if($Event->status ==0){
            $Event->status = 1;
        }else{
            $Event->status = 0;
        }
        $Event->save();
        return response()->json(['message' => 'Event Status Change'],200);
    }
    function EventDelete($id){
              
        $Event = Event::find($id);
        $Event->delete();
        return response()->json(['message' => 'Event Deleted Successfully'],200);
    }
        
}
