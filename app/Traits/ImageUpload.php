<?php

namespace App\Traits;
use Illuminate\Support\Str;


trait ImageUpload
{
    public function imageUpload($request,$path){
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/'.$path), $file_name);
        }  
        return $file_name ;

    }
}