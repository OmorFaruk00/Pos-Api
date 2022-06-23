<?php

namespace App\Http\Controllers\DUM;

use Illuminate\Http\Request;
use App\Models\DUM\Program;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class ProgramController extends Controller
{
    function ProgramAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',


        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');


            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
        }
        $Program = new Program();
        $Program->name = $request->name;
        $Program->duration = $request->duration;
        $Program->image = $file_name;
        $Program->status = 1;
        $Program->created_by = auth()->user()->id;
        $Program->save();
        return response()->json(['message' => 'Program Added Successfully'], 200);
    }



    function ProgramShow()
    {
        return Program::all();
    }
    function ProgramEdit($id)
    {
        return Program::find($id);
    }
    function ProgramUpdate(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $Program = Program::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
            unlink(public_path() . '/images/dum/' . $Program->image);
        }

        $Program->name = $request->name;
        $Program->duration = $request->duration;
        $Program->image = $file_name ?? $Program->image;
        $Program->status = 1;
        $Program->created_by = auth()->user()->id;
        $Program->save();
        return response()->json(['message' => 'Program Updated Successfully'], 200);
    }
    function ProgramStatus($id)
    {
        $Program = Program::find($id);
        if ($Program->status == 0) {
            $Program->status = 1;
        } else {
            $Program->status = 0;
        }
        $Program->save();
        return response()->json(['message' => 'Program Status Change'], 200);
    }
    function ProgramDelete($id)
    {
        $Program = Program::find($id);
        unlink(public_path() . '/images/dum/' . $Program->image);
        $Program->delete();
        return response()->json(['message' => 'Program Deleted Successfully'], 200);
    }
}
