<?php

namespace App\Http\Controllers\ADM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Student;
use App\Models\User;
use App\Models\Education;
use App\Models\Admission_form;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Admissioncontroller extends Controller
{
    public function activeDepartment()
    {
        return Section::where('status', 1)->get();
    }
    public function getShiftGroup($id)
    {
        return Batch::where('id', $id)->get();
    }


    public function admissionStore(Request $request)
    {
           $this->validate($request, [
               'department_id' => 'required|integer',
               'batch_id' => 'required|integer',
               'shift_id' => 'required|integer',
               'group_id' => 'required|integer',
               'adm_frm_sl' => 'required|max:20',               
               'student_name' => 'required|string|max:80',
               'blood_group' => 'required|max:4',
               'email' => 'required|email',
               'phone_no' => 'required|numeric',
               'religion_id' => 'required|integer',
               'gender' => 'required|max:1',
               'dob' => 'required',

               'birth_place' => 'nullable|max:30',
               'fg_monthly_income' => 'nullable|numeric',
               'nationality' => 'required|max:30',
               'std_birth_or_nid_no' => 'nullable|max:50',
               'marital_status' => 'required|max:20',
               'permanent_add' => 'required|string',
               'mailing_add' => 'required|string',
               'f_name' => 'required|string|max:80',
               'f_cellno' => 'required|numeric',
               'f_occu' => 'nullable|string|max:30',
               'father_nid_no' => 'required|numeric',
               'm_name' => 'required|string|max:80',
               'm_cellno' => 'nullable|numeric',
               'm_occu' => 'nullable|string|max:30',
               'mother_nid_no' => 'nullable|numeric',
               'g_name' => 'nullable|string|max:30',
               'g_cellno' => 'nullable|numeric',
               'g_occu' => 'nullable|string|max:30',
               'e_name' => 'required|string|max:30',
               'e_cellno' => 'required|numeric',
               'e_occu' => 'nullable|string|max:30',
               'e_relation' => 'nullable|string|max:20',

               'e_exam_name1' => 'required|string',
               'e_group1' => 'required|string',
               'e_roll_no_1' => 'required|numeric',
               'e_passing_year1' => 'required|max:4',
               'e_ltr_grd_tmarks1' => 'required',
               'e_div_cls_cgpa1' => 'required',
               'e_board_institute1' => 'required',

               'e_exam_name2' => 'required|string',
               'e_group2' => 'required|string',
               'e_roll_no_2' => 'required|numeric',
               'e_passing_year2' => 'required|max:4',
               'e_ltr_grd_tmarks2' => 'required',
               'e_div_cls_cgpa2' => 'required',
               'e_board_institute2' => 'required',

               'e_exam_name3' => 'nullable|string',
               'e_group3' => 'nullable|string',
               'e_roll_no_3' => 'nullable|numeric',
               'e_passing_year3' => 'nullable|max:4',
               'e_ltr_grd_tmarks3' => 'nullable',
               'e_div_cls_cgpa3' => 'nullable',
               'e_board_institute3' => 'nullable',

               'e_exam_name4' => 'nullable|string',
               'e_group4' => 'nullable|string',
               'e_roll_no_4' => 'nullable|numeric',
               'e_passing_year4' => 'nullable|max:4',
               'e_ltr_grd_tmarks4' => 'nullable',
               'e_div_cls_cgpa4' => 'nullable',
               'e_board_institute4' => 'nullable',
              
               'file' => 'required|mimes:jpeg,jpg,png|max:1024',
               'signature' => 'required|mimes:jpeg,jpg,png|max:500',
           ]);

        try {

            DB::transaction(function () use ($request) {
                $files = $request->file('signature');
                $images = $request->file('file');

                if ($files) {

                    $extension = $files->getClientOriginalExtension();
                    $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $files->move(public_path('images/student_signature'), $file_name);
                }
                if ($images) {

                    $extension = $images->getClientOriginalExtension();
                    $image_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $images->move(public_path('images/student_photo'), $image_name);
                }
                $student = new Student();
                $student->department_id = $request->department_id;
                $student->batch_id = $request->batch_id;
                $student->shift_id = $request->shift_id;
                $student->group_id = $request->group_id;
                $student->adm_frm_sl = $request->adm_frm_sl;
                $student->student_name = $request->student_name;
                $student->roll_no = $request->roll_no;
                $student->reg_code = $request->reg_no;
                $student->blood_group = $request->blood_group;
                $student->email = $request->email;
                $student->phone_no = $request->phone_no;
                $student->religion_id = $request->religion_id;
                $student->gender = $request->gender;
                $student->dob = $request->dob;
                $student->birth_place = $request->birth_place;
                $student->std_birth_or_nid_no = $request->std_birth_or_nid_no;
                $student->fg_monthly_income = $request->fg_monthly_income;
                $student->permanent_add = $request->permanent_add;
                $student->mailing_add = $request->mailing_add;
                $student->f_name = $request->f_name;
                $student->f_cellno = $request->f_cellno;
                $student->f_occu = $request->f_occu;
                $student->father_nid_no = $request->father_nid_no;
                $student->m_name = $request->m_name;
                $student->m_cellno = $request->m_cellno;
                $student->m_occu = $request->m_occu;
                $student->mother_nid_no = $request->mother_nid_no;
                $student->g_name = $request->g_name;
                $student->g_cellno = $request->g_cellno;
                $student->g_occu = $request->g_occu;
                $student->e_name = $request->e_name;
                $student->e_cellno = $request->e_cellno;
                $student->e_occu = $request->e_occu;
                $student->e_relation = $request->e_relation;
                $student->refereed_by = $request->refereed_by;
                $student->refereed_by_email = $request->refereed_by_email;
                $student->nationality = $request->nationality;
                $student->marital_status = $request->marital_status;
                $student->admission_by = auth()->user()->id;
                $student->adm_date = Carbon::now()->format('Y-m-d');
                $student->photo = $image_name;
                $student->signature = $file_name;
                $student->save();

                $batch = Batch::find($request->batch_id);
                if($batch->available_seat >0){
                $available_seat = $batch->available_seat - 1 ;
                $batch->available_seat = $available_seat;                
                }
                $batch->save();

                $admisson_form = Admission_form::where('form_number',$request->adm_frm_sl)->update([
                'roll' => $request->roll_no,
                'reg_code' => $request->reg_no, 
                'admission_date' => Carbon::now()->format('Y-m-d'), 
                'admission_by' => auth()->user()->id,
                ]);            
                
                $education = new Education();
                $education->exam_name1 = $request->e_exam_name1;
                $education->student_reg_code = $request->reg_no;
                $education->group1 = $request->e_group1;
                $education->roll_no1 = $request->e_roll_no_1;
                $education->passing_year1 = $request->e_passing_year1;
                $education->ltr_grd_tmarks1 = $request->e_ltr_grd_tmarks1;
                $education->div_cls_cgpa1 = $request->e_div_cls_cgpa1;
                $education->board_institute1 = $request->e_board_institute1;
                $education->exam_name2 = $request->e_exam_name2;
                $education->group2 = $request->e_group2;
                $education->roll_no2 = $request->e_roll_no_2;
                $education->passing_year2 = $request->e_passing_year2;
                $education->ltr_grd_tmarks2 = $request->e_ltr_grd_tmarks2;
                $education->div_cls_cgpa2 = $request->e_div_cls_cgpa2;
                $education->board_institute2 = $request->e_board_institute2;
                $education->exam_name3 = $request->e_exam_name3;
                $education->group3 = $request->e_group3;
                $education->roll_no3 = $request->e_roll_no_3;
                $education->passing_year3 = $request->e_passing_year3;
                $education->ltr_grd_tmarks3 = $request->e_ltr_grd_tmarks3;
                $education->div_cls_cgpa3 = $request->e_div_cls_cgpa3;
                $education->board_institute3 = $request->e_board_institute3;
                $education->exam_name4 = $request->e_exam_name4;
                $education->group4 = $request->e_group4;
                $education->roll_no4 = $request->e_roll_no_4;
                $education->passing_year4 = $request->e_passing_year4;
                $education->ltr_grd_tmarks4 = $request->e_ltr_grd_tmarks4;
                $education->div_cls_cgpa4 = $request->e_div_cls_cgpa4;
                $education->board_institute4 = $request->e_board_institute4;
                $education->save();

            });
            return response()->json(['message' => 'Student Admission Successfull'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
    public function departmentWiseStudent(Request $request,$dept_id,$batch_id){
        try {

           return Student::where('DEPARTMENT_ID',$dept_id)->where('BATCH_ID',$batch_id)->get();
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }
    }
    public function searchStudent($item){
        try {           
           return Student::where(function ($query) use ($item) {
            $query->where('reg_code', 'LIKE', "%" . $item . "%")                
                ->orWhere('student_name', 'LIKE', "%" . $item . "%");
        })->get();
          
          } catch (\Exception $e) {          
              return $e->getMessage();
          }
    }
    public function studentEdit($id){
        try {              
           return Student::with('education')->where('id',$id)->first();     
          
          } catch (\Exception $e) {          
              return $e->getMessage();
          }
    }
    public function studentUpdate(Request $request,$id){
        try {
            // $this->validate($request, [
            //     'department_id' => 'required|integer',
            //     'batch_id' => 'required|integer',
            //     'shift_id' => 'required|integer',
            //     'group_id' => 'required|integer',
            //     'adm_frm_sl' => 'required|max:20',               
            //     'student_name' => 'required|string|max:80',
            //     'blood_group' => 'required|max:4',
            //     'email' => 'required|email',
            //     'phone_no' => 'required|numeric',
            //     'religion_id' => 'required|integer',
            //     'gender' => 'required|max:1',
            //     'dob' => 'required',
 
            //     'birth_place' => 'nullable|max:30',
            //     'fg_monthly_income' => 'nullable|numeric',
            //     'nationality' => 'required|max:30',
            //     'std_birth_or_nid_no' => 'nullable|max:50',
            //     'marital_status' => 'required|max:20',
            //     'permanent_add' => 'required|string',
            //     'mailing_add' => 'required|string',
            //     'f_name' => 'required|string|max:80',
            //     'f_cellno' => 'required|numeric',
            //     'f_occu' => 'nullable|string|max:30',
            //     'father_nid_no' => 'required|numeric',
            //     'm_name' => 'required|string|max:80',
            //     'm_cellno' => 'nullable|numeric',
            //     'm_occu' => 'nullable|string|max:30',
            //     'mother_nid_no' => 'nullable|numeric',
            //     'g_name' => 'nullable|string|max:30',
            //     'g_cellno' => 'nullable|numeric',
            //     'g_occu' => 'nullable|string|max:30',
            //     'e_name' => 'required|string|max:30',
            //     'e_cellno' => 'required|numeric',
            //     'e_occu' => 'nullable|string|max:30',
            //     'e_relation' => 'nullable|string|max:20',
 
            //     'e_exam_name1' => 'required|string',
            //     'e_group1' => 'required|string',
            //     'e_roll_no_1' => 'required|numeric',
            //     'e_passing_year1' => 'required|max:4',
            //     'e_ltr_grd_tmarks1' => 'required',
            //     'e_div_cls_cgpa1' => 'required',
            //     'e_board_institute1' => 'required',
 
            //     'e_exam_name2' => 'required|string',
            //     'e_group2' => 'required|string',
            //     'e_roll_no_2' => 'required|numeric',
            //     'e_passing_year2' => 'required|max:4',
            //     'e_ltr_grd_tmarks2' => 'required',
            //     'e_div_cls_cgpa2' => 'required',
            //     'e_board_institute2' => 'required',
 
            //     'e_exam_name3' => 'nullable|string',
            //     'e_group3' => 'nullable|string',
            //     'e_roll_no_3' => 'nullable|numeric',
            //     'e_passing_year3' => 'nullable|max:4',
            //     'e_ltr_grd_tmarks3' => 'nullable',
            //     'e_div_cls_cgpa3' => 'nullable',
            //     'e_board_institute3' => 'nullable',
 
            //     'e_exam_name4' => 'nullable|string',
            //     'e_group4' => 'nullable|string',
            //     'e_roll_no_4' => 'nullable|numeric',
            //     'e_passing_year4' => 'nullable|max:4',
            //     'e_ltr_grd_tmarks4' => 'nullable',
            //     'e_div_cls_cgpa4' => 'nullable',
            //     'e_board_institute4' => 'nullable',
 
               
            //     'file' => 'required|mimes:jpeg,jpg,png|max:1024',
            //     'signature' => 'required|mimes:jpeg,jpg,png|max:500',
            // ]);
            

            DB::transaction(function () use ($request,$id) {
                $files = $request->file('signature');
                $images = $request->file('file');

                if ($files)
                {
                    $extension = $files->getClientOriginalExtension();
                    $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $files->move(public_path('images/student_signature'), $file_name);
                }
                if ($images)
                {
                    $extension = $images->getClientOriginalExtension();
                    $image_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $images->move(public_path('images/student_photo'), $image_name);
                }
                
                $student = Student::find($id);               
                $student->department_id = $request->department_id;
                $student->batch_id = $request->batch_id;
                $student->shift_id = $request->shift_id;
                $student->group_id = $request->group_id;
                $student->adm_frm_sl = $request->adm_frm_sl;
                $student->student_name = $request->student_name;
                $student->roll_no = $request->roll_no;              
                $student->blood_group = $request->blood_group;
                $student->email = $request->email;
                $student->phone_no = $request->phone_no;
                $student->religion_id = $request->religion_id;
                $student->gender = $request->gender;
                $student->dob = $request->dob;
                $student->birth_place = $request->birth_place;
                $student->std_birth_or_nid_no = $request->std_birth_or_nid_no;
                $student->fg_monthly_income = $request->fg_monthly_income;
                $student->permanent_add = $request->permanent_add;
                $student->mailing_add = $request->mailing_add;
                $student->f_name = $request->f_name;
                $student->f_cellno = $request->f_cellno;
                $student->f_occu = $request->f_occu;
                $student->father_nid_no = $request->father_nid_no;
                $student->m_name = $request->m_name;
                $student->m_cellno = $request->m_cellno;
                $student->m_occu = $request->m_occu;
                $student->mother_nid_no = $request->mother_nid_no;
                $student->g_name = $request->g_name;
                $student->g_cellno = $request->g_cellno;
                $student->g_occu = $request->g_occu;
                $student->e_name = $request->e_name;
                $student->e_cellno = $request->e_cellno;
                $student->e_occu = $request->e_occu;
                $student->e_relation = $request->e_relation;
                $student->refereed_by = $request->refereed_by;
                $student->refereed_by_email = $request->refereed_by_email;
                $student->nationality = $request->nationality;
                $student->marital_status = $request->marital_status;
                $student->admission_by = auth()->user()->id;                
                $student->photo = $image_name??$student->photo;
                $student->signature = $file_name??$student->signature;
                $student->save();                
   
                $education =  Education::where('student_reg_code',$student->reg_code)->first();                             
                $education->exam_name1 = $request->exam_name1;                
                $education->group1 = $request->group1;
                $education->roll_no1 = $request->roll_no1;
                $education->passing_year1 = $request->passing_year1;
                $education->ltr_grd_tmarks1 = $request->ltr_grd_tmarks1;
                $education->div_cls_cgpa1 = $request->div_cls_cgpa1;
                $education->board_institute1 = $request->board_institute1;

                $education->exam_name2 = $request->exam_name2;
                $education->group2 = $request->group2;
                $education->roll_no2 = $request->roll_no2;
                $education->passing_year2 = $request->passing_year2;
                $education->ltr_grd_tmarks2 = $request->ltr_grd_tmarks2;
                $education->div_cls_cgpa2 = $request->div_cls_cgpa2;
                $education->board_institute2 = $request->board_institute2;

                $education->exam_name3 = $request->exam_name3;
                $education->group3 = $request->group3;
                $education->roll_no3 = $request->roll_no3;
                $education->passing_year3 = $request->passing_year3;
                $education->ltr_grd_tmarks3 = $request->ltr_grd_tmarks3;
                $education->div_cls_cgpa3 = $request->div_cls_cgpa3;
                $education->board_institute3 = $request->board_institute3;

                $education->exam_name4 = $request->exam_name4;
                $education->group4 = $request->group4;
                $education->roll_no4 = $request->roll_no4;
                $education->passing_year4 = $request->passing_year4;
                $education->ltr_grd_tmarks4 = $request->ltr_grd_tmarks4;
                $education->div_cls_cgpa4 = $request->div_cls_cgpa4;
                $education->board_institute4 = $request->board_institute4;
                $education->save();


            });         


            return response()->json(['message' => 'Student Update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
