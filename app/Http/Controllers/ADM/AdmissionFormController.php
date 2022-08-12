<?php

namespace App\Http\Controllers\ADM;

use Illuminate\Http\Request;
use App\Models\Admission_form;
use App\Models\Form_stock;
use App\Models\Course;
use App\Models\Employee;
use App\Models\Batch;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;



class AdmissionFormController extends Controller
{

    public function importForm(Request $request)
    {
        $this->validate(
            $request,
            [
                'start' => ['required', 'numeric'],
                'end' => ['required', 'numeric'],
                'count' => ['required', 'numeric'],
            ]
        );

        try {
            DB::transaction(function () use ($request) {
                $stock = new Form_stock();
                $stock->start = $request->start;
                $stock->end = $request->end;
                $stock->count = $request->count;
                $stock->created_by = auth()->user()->id;
                $stock->save();

                $form_details = [];
                $start = $request->start;
                for ($i = 0; $i < $request->count; $i++) {
                    $form_details[$i]['form_number'] = $start;
                    $start++;
                }               
                Admission_form::insert($form_details);
            });

            return response()->json(['message' => 'Form Import Successfully'], 200);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 406);
        }
    }
    public function stockForm()
    {
        try {
            $stock = Form_stock::all();
            return response()->json(['data' => $stock], 200);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 406);
        }
    }
    public function searchForm(Request $request, $form)
    {

        // $request->validate([
        //         'form_number' => 'required|numeric',

        //     ]);
        try {
            
            $form_details = Admission_form::where('form_number', $form)
                ->whereNull('name_of_student')
                ->whereNull('dept_id')
                ->whereNull('batch_id')
                ->first();

            if (empty($form_details)) {
                $form_info = Admission_form::with('batch', 'department','employee')->where('form_number', $form)->first();
                return response()->json(['form_info' => $form_info], 302);
            }

            return $form_details;
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 406);
        }
    }
    public function getDepartment(Request $request)
    {
        try {
            $department = Section::all();
            return response()->json(['data' => $department], 200);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 406);
        }
    }
    public function getBatch(Request $request, $id)
    {
        try {
            $data = Batch::where('department_id', $id)->where('status',1)->get();
            return response()->json(['data' => $data], 200);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 406);
        }
    }
    public function formSale(Request $request, $form)
    {

        $this->validate($request, [
            'student_name' => ['required', 'string'],
            'department' => ['required', 'numeric'],
            'batch' => ['required', 'numeric'],
        ]);
        $form =  Admission_form::where('form_number', $form)
            ->whereNull('name_of_student')
            ->whereNull('dept_id')
            ->whereNull('batch_id')
            ->first();

        if (!$form) {
            return response(['message' => 'From sold just now'], 406);
        }

        try {
            $form->name_of_student = $request->student_name;
            $form->dept_id = $request->department;
            $form->batch_id = $request->batch;
            $form->sale_by = auth()->user()->id;
            $form->sale_date = Carbon::now()->format('Y-m-d');
            $form->save();  

            $receipt_no = 'FS'.$form;

            return response(['message' => 'Form Sold Successfully', 'receipt_no' => $receipt_no], 200);

        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 400);
        }
        
    }

    public function generatePDF($form_no)
    {  
        
         $student = Admission_form::with('department','batch')->where('form_number',$form_no)->first();
         $employee_info = Employee::with('relDesignation')->find(auth()->user()->id);
         $employee['name'] = $employee_info->name;
         $employee['designation'] = $employee_info->relDesignation->designation;
         $payable = 1000;
         $recieve_id = "FS" .$form_no;
         $date = Carbon::now()->format('Y-m-d');

         $customPaper = array(0,0,720,1440);
        $pdf = PDF::loadView('admission_slip',compact('student','payable','recieve_id','employee','date'))->setPaper($customPaper, 'landscape');       
        return $pdf->stream('print.pdf');
        
    }

    
    public function printShow(){
        $student = Admission_form::where('form_number',100)->first();
        return view('admission_slip',['student'=>$student]);

    }

   
}
