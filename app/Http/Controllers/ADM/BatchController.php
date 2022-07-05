<?php

namespace App\Http\Controllers\ADM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;


class BatchController extends Controller
{
    public function batchShow(){
        try {            

            return Batch::with('department')->get();
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }

    }
    public function batchAdd(Request $request){
        try {

            $request->validate([
                'department'=>"required",
                'duration'=>"required",
                    'group'=>"required",
                    'shift'=>"required",               
                    'batch_name'=>"required",
                    'said_fee'=>"required",
                    'common_scholarship'=>"required",              
                    'no_of_seat'=>"required",
                    'year'=>"required",
                    'session'=>"required",
                    'admission_season'=>"required",                    
                    'id_card_expiration_date'=>"required",
                    'class_start_date'=>"required",
                    'last_data_of_admission'=>"required",                
                    'admission_start_date'=>"required",
    
            ]);  
    
            $batch = new Batch();
            $batch->batch_name=$request->batch_name;
            $batch->department_id=$request->department;
            $batch->duration=$request->duration;
            $batch->group=$request->group;
            $batch->shift=$request->shift;
            $batch->said_fee=$request->said_fee;
            $batch->common_scholarship=$request->common_scholarship;
            $batch->no_of_seat=$request->no_of_seat;
            $batch->year=$request->year;
            $batch->session=$request->session;
            $batch->admission_season=$request->admission_season;
            $batch->status=1;
            $batch->id_card_expiration_date=$request->id_card_expiration_date;
            $batch->class_start_date=$request->class_start_date;
            $batch->admission_start_date=$request->admission_start_date;
            $batch->last_data_of_admission=$request->last_data_of_admission;
            $batch->created_by=auth()->user()->id; 
            $batch->save();       
            return response()->json(['message'=>"Batch Added Successfully"],200);
            
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }
       

    }
    public function batchEdit($id){
        try {

            return Batch::find($id)->first();
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }

    }
    public function batchUpdate(Request $request, $id){
        try {
            

            $request->validate([
                'department_id'=>"required",
                'duration'=>"required",
                    'group'=>"required",
                    'shift'=>"required",               
                    'batch_name'=>"required",
                    'said_fee'=>"required",
                    'common_scholarship'=>"required",              
                    'no_of_seat'=>"required",
                    'year'=>"required",
                    'session'=>"required",
                    'admission_season'=>"required",                   
                    'id_card_expiration_date'=>"required",
                    'class_start_date'=>"required",
                    'last_data_of_admission'=>"required",                
                    'admission_start_date'=>"required",
    
            ]);  
    
            $batch =  Batch::find($id);            
            $batch->batch_name=$request->batch_name;
            $batch->department_id=$request->department_id;
            $batch->duration=$request->duration;
            $batch->group=$request->group;
            $batch->shift=$request->shift;
            $batch->said_fee=$request->said_fee;
            $batch->common_scholarship=$request->common_scholarship;
            $batch->no_of_seat=$request->no_of_seat;
            $batch->year=$request->year;
            $batch->session=$request->session;
            $batch->admission_season=$request->admission_season;           
            $batch->id_card_expiration_date=$request->id_card_expiration_date;
            $batch->class_start_date=$request->class_start_date;
            $batch->admission_start_date=$request->admission_start_date;
            $batch->last_data_of_admission=$request->last_data_of_admission;
            $batch->created_by=auth()->user()->id; 
            $batch->save();       
            return response()->json(['message'=>"Batch Update Successfully"],200);
            
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }

    }
    public function batchStatus($id){
        try {

            $batch = Batch::find($id);
            if($batch->status ==0){
                $batch->status = 1;
            }else{
                $batch->status = 0;
            }
            $batch->save();
            return response()->json(['message' => 'Batch Status Change'],200);
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }

    }
    public function batchDelete($id){
        try {

            $batch = Batch::find($id);
            
            $batch->delete();
            return response()->json(['message' => 'Batch Deleted Successfully'],200);
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }

    }
   
}
