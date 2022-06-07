<?php

namespace App\Http\Controllers\DUM;

use Illuminate\Http\Request;
use App\Models\DUM\notice;
use App\Http\Controllers\Controller;
class NoticeController extends Controller
{
    function noticeAdd(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required|unique:notices',            
        ]);
        $notice = new notice();
        $notice->title = $request->title;
        $notice->description = $request->description;
        $notice->slug = $request->slug;
        $notice->status = 1;
        $notice->created_by = auth()->user()->name;  
        $notice->save();
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
            
        ]);
        $notice = notice::find($id);
        $notice->title = $request->title;
        $notice->description = $request->description;        
        $notice->status = 1;
        $notice->created_by = auth()->user()->name;
        $notice->save();
        return response()->json(['message' => 'Notice Updated Successfully'],200);

    }
    function noticeStatus($id,$status){
        $notice = notice::find($id);
        if($notice->status ==0){
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
