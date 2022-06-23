<?php

namespace App\Http\Controllers\DUM;
use Illuminate\Http\Request;
use App\Models\DUM\notice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
class NoticeController extends Controller
{
    function noticeAdd(Request $request){
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
        $Notice = new notice();
        $Notice->title = $request->title;
        $Notice->description = $request->description;        
        $Notice->image = $file_name;
        $Notice->status = 1;
        $Notice->created_by = auth()->user()->id;        
        $Notice->save();
        return response()->json(['message' => 'Notice Added Successfully'],200);
    }


    
    function noticeShow(){
        return notice::all();
        
        
    }
    function noticeEdit($id){
        return notice::find($id);

    }
    function noticeUpdate(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'description' => 'required', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',          
            
        ]);
        $Notice = notice::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');       

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
            $image_url = env('APP_URL') . "/images/dum/$file_name"; 
            unlink(public_path() .'/images/dum/'. $Notice->image);          
        }
        
        $Notice->title = $request->title;
        $Notice->description = $request->description;     
        $Notice->image = $file_name??$Notice->image;
        $Notice->status = 1;
        $Notice->created_by = auth()->user()->name;        
        $Notice->save();
        return response()->json(['message' => 'Notice Updated Successfully'],200);

    }
    function noticeStatus($id){
        $notice = notice::find($id);
        if($notice->status == 0){
            $notice->status = 1;
        }else{
            $notice->status = 0;
        }
        $notice->save();
        return response()->json(['message' => 'Notice Status Change'],200);
    }
    function noticeDelete($id){
              
        $notice = notice::find($id);
        $notice->delete();
        return response()->json(['message' => 'Notice Deleted Successfully'],200);
    }
        
        
        
    
}
