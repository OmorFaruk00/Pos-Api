<?php

namespace App\Http\Controllers\DUM;

use Illuminate\Http\Request;
use App\Models\DUM\Committee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class CommitteeController extends Controller
{
    function CommitteeAdd(Request $request){
        $request->validate([
            'committee_type' => 'required',
            'member_name' => 'required', 
            'member_type' => 'required',
            'profession'=>'required',                        
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'personal_phone_no' => 'required',
            'nid_no' => 'required',
            
         

                                   
        ]);
        
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
        

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
                      
        }
        $Committee = new Committee();
        $Committee->committee_type = $request->committee_type;
        $Committee->member_name = $request->member_name;
        $Committee->member_type = $request->member_type;
        $Committee->profession = $request->profession;        
        $Committee->personal_phone_no = $request->personal_phone_no;      
        $Committee->alternative_phone_no = $request->personal_phone_no;      
        $Committee->home_phone_no = $request->personal_phone_no;            
        $Committee->nid_no = $request->nid_no;
        $Committee->date_of_birth = $request->date_of_birth;        ;        
        $Committee->image = $file_name;
        $Committee->status = 1;
        $Committee->created_by = auth()->user()->id;        
        $Committee->save();
        return response()->json(['message' => 'Committee Added Successfully'],200);
    }


    
    function CommitteeShow(){
        return Committee::all();
        
        
    }
    function CommitteeEdit($id){
        
        return Committee::find($id);


    }
    function CommitteeUpdate(Request $request,$id){
        $request->validate([
            'committee_type' => 'required',
            'member_name' => 'required', 
            'member_type' => 'required',
            'profession'=>'required',                        
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'personal_phone_no' => 'required',
            'nid_no' => 'required',
            
         

                                   
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
        

        $extension = $file->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/dum'), $file_name);
                      
        }
        $Committee =  Committee::find($id);
        $Committee->committee_type = $request->committee_type;
        $Committee->member_name = $request->member_name;
        $Committee->member_type = $request->member_type;
        $Committee->profession = $request->profession;        
        $Committee->personal_phone_no = $request->personal_phone_no;      
        $Committee->alternative_phone_no = $request->personal_phone_no;      
        $Committee->home_phone_no = $request->personal_phone_no;            
        $Committee->nid_no = $request->nid_no;
        $Committee->date_of_birth = $request->date_of_birth;       
        $Committee->image = $file_name ?? $Committee->image;        
        $Committee->created_by = auth()->user()->id;        
        $Committee->save();
        return response()->json(['message' => 'Committee Updated Successfully'],200);

    }
    function CommitteeStatus($id){
        $Committee = Committee::find($id);
        if($Committee->status ==0){
            $Committee->status = 1;
        }else{
            $Committee->status = 0;
        }
        $Committee->save();
        return response()->json(['message' => 'Committee Status Change'],200);
    }
    function CommitteeDetails($id){
        return Committee::with('relDesignation','relDepartment','relSocial','relTraining','relQualification')->where('id',$id)->first();
    }

    function CommitteeDelete($id){              
        $Committee = Committee::find($id);        
        // unlink(public_path() .'/images/emp/'. $Committee->image);
        $Committee->delete();
        return response()->json(['message' => 'Committee Deleted Successfully'],200);
    }
   
        
        
        
    
}
