<?php

namespace App\Http\Controllers\DUM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DUM\Contact;
use App\Models\DUM\Gallery;
use Illuminate\Support\Str;

class DumController extends Controller
{
    public function ContactShow(){
        return Contact::all();
    }
    private function fileUpload($file)
    {
        try {
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/gallery'), $file_name);
            $image_url = env('APP_URL') . "/images/gallery/$file_name";
            return $file_name;
        } catch (\Exception $e) {
            throw new \Error($e->getMessage(), 500);
        }
    }

    public function GalleryAdd(Request $request){  
        
        $request->validate([
           'gallery_type' =>'required',                    
            // 'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            
        ]);
        $files = $request->file('image');     

                $imageData = [];
                foreach ($files as $file) {
                 $file_name = $this->fileUpload($file);
                 $gallery = new Gallery();
                 $gallery->image =  $file_name;
                 $gallery->type = $request->gallery_type;
                 $gallery->created_by = 4;
                 $gallery->save();

                    
                }
                return response()->json(['message' => 'Image Added Successfully'],200);
               
               
        
    }
}
