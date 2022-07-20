<?php

namespace App\Http\Controllers\ADM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Student;
use App\Models\User;
use App\Models\Education;
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

        //    $this->validate($request, [
        //        'department_id' => 'required|integer',
        //        'batch_id' => 'required|integer',
        //        'shift_id' => 'required|integer',
        //        'group_id' => 'required|integer',
        //        'adm_frm_sl' => 'required|max:20',
        //        'admission_season' => 'required|integer',
        //        'student_name' => 'required|string|max:80',
        //        'blood_group' => 'required|max:4',
        //        'email' => 'required|email',
        //        'phone_no' => 'required|max:15',
        //        'religion_id' => 'required|integer',
        //        'gender' => 'required|max:1',
        //        'dob' => 'required',

        //        'birth_place' => 'nullable|max:30',
        //        'fg_monthly_income' => 'nullable|numeric',
        //        'nationality' => 'required|max:30',
        //        'std_birth_or_nid_no' => 'nullable|max:50',
        //        'marital_status' => 'required|max:20',
        //        'permanent_add' => 'required|string|max:200',
        //        'mailing_add' => 'required|string|max:100',
        //        'f_name' => 'required|string|max:80',
        //        'f_cellno' => 'required|string|max:15',
        //        'f_occu' => 'nullable|string|max:30',
        //        'father_nid_no' => 'required|max:50',
        //        'm_name' => 'required|string|max:80',
        //        'm_cellno' => 'nullable|max:15',
        //        'm_occu' => 'nullable|string|max:30',
        //        'mother_nid_no' => 'nullable|max:50',
        //        'g_name' => 'nullable|string|max:30',
        //        'g_cellno' => 'nullable|max:15',
        //        'g_occu' => 'nullable|string|max:30',
        //        'e_name' => 'required|string|max:30',
        //        'e_cellno' => 'required|max:15',
        //        'e_occu' => 'nullable|string|max:30',
        //        'e_relation' => 'nullable|string|max:20',

        //        'e_exam_name1' => 'required|string|max:40',
        //        'e_group1' => 'required|string|max:20',
        //        'e_roll_no_1' => 'required|max:10',
        //        'e_passing_year1' => 'required|max:4',
        //        'e_ltr_grd_tmarks1' => 'required|max:10',
        //        'e_div_cls_cgpa1' => 'required|max:10',
        //        'e_board_university1' => 'required|max:50',
        //        'e_exam_name2' => 'required|string|max:40',
        //        'e_group2' => 'required|string|max:20',
        //        'e_roll_no_2' => 'required|max:10',
        //        'e_passing_year2' => 'required|max:4',
        //        'e_ltr_grd_tmarks2' => 'required|max:10',
        //        'e_div_cls_cgpa2' => 'required|max:10',
        //        'e_board_university2' => 'required|max:50',

        //        'e_exam_name3' => 'nullable|string|max:40',
        //        'e_group3' => 'nullable|string|max:20',
        //        'e_roll_no_3' => 'nullable|max:10',
        //        'e_passing_year3' => 'nullable|max:4',
        //        'e_ltr_grd_tmarks3' => 'nullable|max:10',
        //        'e_div_cls_cgpa3' => 'nullable|max:10',
        //        'e_board_university3' => 'nullable|max:50',

        //        'e_exam_name4' => 'nullable|string|max:40',
        //        'e_group4' => 'nullable|string|max:20',
        //        'e_roll_no_4' => 'nullable|max:10',
        //        'e_passing_year4' => 'nullable|max:4',
        //        'e_ltr_grd_tmarks4' => 'nullable|max:10',
        //        'e_div_cls_cgpa4' => 'nullable|max:10',
        //        'e_board_university4' => 'nullable|max:50',

        //        'refereed_by_parent_id' => 'nullable|integer',
        //        'refe_by_std_type' => 'nullable|max:50',
        //        'ref_val' => 'nullable|max:50',
        //        'file' => 'required|mimes:jpeg,jpg,png|max:1024',
        //        'signature' => 'required|mimes:jpeg,jpg,png|max:500',
        //    ]);

        try {

            DB::transaction(function () use ($request) {
                $files = $request->file('signature');
                $images = $request->file('file');

                if ($files) {

                    $extension = $files->getClientOriginalExtension();
                    $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $files->move(storage_path('images/student_signature'), $file_name);
                }
                if ($images) {

                    $extension = $images->getClientOriginalExtension();
                    $image_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $images->move(storage_path('images/student_photo'), $image_name);
                }
                $student = new Student();
                $student->DEPARTMENT_ID = $request->department_id;
                $student->BATCH_ID = $request->batch_id;
                $student->SHIFT_ID = $request->shift_id;
                $student->GROUP_ID = $request->group_id;
                $student->ADM_FRM_SL = $request->adm_frm_sl;
                $student->NAME = $request->student_name;
                $student->ROLL_NO = $request->roll_no;
                $student->REG_CODE = $request->reg_no;
                $student->BLOOD_GROUP = $request->blood_group;
                $student->EMAIL = $request->email;
                $student->PHONE_NO = $request->phone_no;
                $student->RELIGION = $request->religion_id;
                $student->GENDER = $request->gender;
                $student->DOB = $request->dob;
                $student->BIRTH_PLACE = $request->birth_place;
                $student->STD_BIRTH_OR_NID_NO = $request->std_birth_or_nid_no;
                $student->FG_MONTHLY_INCOME = $request->fg_monthly_income;
                $student->PARMANENT_ADD = $request->permanent_add;
                $student->MAILING_ADD = $request->mailing_add;
                $student->F_NAME = $request->f_name;
                $student->F_CELLNO = $request->f_cellno;
                $student->F_OCCU = $request->f_occu;
                $student->FATHER_NID_NO = $request->father_nid_no;
                $student->M_NAME = $request->m_name;
                $student->M_CELLNO = $request->m_cellno;
                $student->M_OCCU = $request->m_occu;
                $student->MOTHER_NID_NO = $request->mother_nid_no;
                $student->G_NAME = $request->g_name;
                $student->G_CELLNO = $request->g_cellno;
                $student->G_OCCU = $request->g_occu;
                $student->E_NAME = $request->e_name;
                $student->E_CELLNO = $request->e_cellno;
                $student->E_OCCU = $request->e_occu;
                $student->E_RELATION = $request->e_relation;
                $student->NATIONALITY = $request->nationality;
                $student->MARITAL_STATUS = $request->marital_status;
                $student->ADMISSION_BY = auth()->user()->id;
                $student->ADM_DATE = Carbon::now()->format('Y-m-d');
                $student->PHOTO = $image_name;
                $student->SIGNATURE = $file_name;
                $student->save();

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


            return response()->json(['message' => 'Student Admission successfully'], 200);
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
}
