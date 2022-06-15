<?php

namespace App\Http\Controllers\ADM;

use Illuminate\Http\Request;
use App\Models\Admission_form;
use App\Models\Form_stock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class AdmissionFormController extends Controller
{


    public function importForm(Request $request)
    {
     
        $this->validate($request, [
            'start' => ['required','numeric'],
            'end' => ['required','numeric'],
            'count' => ['required','numeric'],
        ]
    );

        try {

            DB::transaction(function () use($request){

                $stock = new Form_stock();
                $stock->start = $request->start;
                $stock->end = $request->end;
                $stock->count = $request->count;
                $stock->created_by = auth()->user()->id;
                $stock->save();

                $form_details = [];
                $start = $request->start;
                for($i=0; $i<$request->count; $i++)
                {
                    $form_details[$i]['form_number'] = $start;
                    $start++;
                }
                Admission_form::insert($form_details);

               
            });
            
            return response()->json(['message' => 'Form Import Successfully'],200);
        }catch (\Exception $exception)
        {
            return response(['error' => $exception->getMessage()], 406);
        }       

    }
    public function stockForm(){
        try{
            $stock = Form_stock::all();
            return response()->json(['data' => $stock],200);
        }catch (\Exception $exception)
        {
            return response(['error' => $exception->getMessage()], 406);
        }

    }
    public function searchForm(Request $request, $form)
    {

        try{
            $form_details = Admission_form::where('form_number', $form)
                    ->whereNull('name_of_student')
                    ->whereNull('dept_id')
                    ->whereNull('batch_id')
                    ->first();
            return response()->json(['data' => $form_details],200);

        if(empty($form_details))
        {
            return response()->json(['message' => 'Form Not Available'],302);          
        }

        }catch(\Exception $exception){
            return response(['error' => $exception->getMessage()], 406);
        }
        

       
    }

    





}
