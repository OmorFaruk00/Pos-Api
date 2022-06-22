<?php

namespace App\Http\Controllers\DUM;
use Illuminate\Http\Request;
use App\Models\DUM\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
class BlogController extends Controller
{
    function BlogAdd(Request $request){
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
        $Blog = new Blog();
        $Blog->title = $request->title;
        $Blog->description = $request->description;        
        $Blog->image = $file_name;
        $Blog->status = 1;
        $Blog->created_by = auth()->user()->name;        
        $Blog->save();
        return response()->json(['message' => 'Blog Added Successfully'],200);
    }


    
    function BlogShow(){
        return Blog::all();
        
        
    }
    function BlogEdit($id){
        return Blog::find($id);

    }
    function BlogUpdate(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'description' => 'required', 
            // 'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',           
            
        ]);
        $Blog = Blog::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');       

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);            
            unlink(public_path() .'/images/dum/'. $Blog->image);          
        }
        
        $Blog->title = $request->title;
        $Blog->description = $request->description;     
        $Blog->image = $file_name??$Blog->image;
        $Blog->status = 1;
        $Blog->created_by = auth()->user()->name;        
        $Blog->save();
        return response()->json(['message' => 'Blog Updated Successfully'],200);

    }
    function BlogStatus($id){
        $blog = Blog::find($id);
        if($blog->status == 0){
            $blog->status = 1;
        }else{
            $blog->status = 0;
        }
        $blog->save();
        return response()->json(['message' => 'Blog Status Change'],200);
    }
    function BlogDelete($id){
              
        $blog = Blog::find($id);
        $blog->delete();
        return response()->json(['message' => 'Blog Deleted Successfully'],200);
    }
        
        
        
    
}
