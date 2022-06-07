<?php

namespace App\Http\Controllers\DUM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DUM\Event;

class EventController extends Controller
{
    function EventAdd(Request $request){
        
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required|unique:events',            
        ]);
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->slug = $request->slug;
        $event->status = 1;
        $event->created_by = auth()->user()->name;
        $event->save();
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
        ]);
        $event = Event::find($id);
        $event->title = $request->title;
        $event->description = $request->description;      
        $event->status = 1;
        $event->created_by = auth()->user()->name;  
        $event->save();
        return response()->json(['message' => 'Event Updated Successfully'],200);

    }
    function EventStatus($id,$status){
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
