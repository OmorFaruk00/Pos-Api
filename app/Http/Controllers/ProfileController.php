<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function userProfile()
    {
        try {
            return Employee::with('relDesignation', 'relDepartment', 'relSocial', 'relTraining', 'relQualification')->where('id', auth()->user()->id)->first();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function updateProfile(Request $request)
    {

        try {

            $request->validate([
                'name' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'personal_phone_no' => 'required',
                'nid_no' => 'required',
                'date_of_birth' => 'required',


            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/emp'), $file_name);
            }
            $User = Employee::find(auth()->user()->id);
            $User->name = $request->name;
            $User->personal_phone_no = $request->personal_phone_no;
            $User->alternative_phone_no = $request->personal_phone_no;
            $User->home_phone_no = $request->personal_phone_no;
            $User->parent_phone_no = $request->parent_phone_no;
            $User->nid_no = $request->nid_no;
            $User->date_of_birth = $request->date_of_birth;
            $User->about = $request->about;
            $User->profile_photo = $file_name ?? $User->profile_photo;

            $User->save();
            return response()->json(['message' => 'Profile Updated Successfully'], 200);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function upload_profile_photo(Request $request){
        try {           

            $request->validate([                
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',             


            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(public_path('images/emp'), $file_name);
            }
            $User = Employee::find(auth()->user()->id);           
            $User->profile_photo = $file_name ?? $User->profile_photo;

            $User->save();
            return response()->json(['message' => 'Profile Picture Updated Successfully'], 200);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
