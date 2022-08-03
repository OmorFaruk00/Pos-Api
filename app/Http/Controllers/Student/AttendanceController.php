<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance_data;
use App\Models\Attendance_report;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;



class AttendanceController extends Controller
{
    function CourseShow()
    {
        try {            
            return Course::with('department','batch','teacher')->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
   
    function assignedCourseShow()
    {
        try {
            $id = auth()->user()->id;
            return Course::with('department','batch')->where('assigned_by_id',$id)->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function AttendanceCourseShow($id)
    {
        try {
            return Course::with('department','batch')->find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function AssignCourseTeacher($course_id,$assign_by){
        try {
            // return $assign_by;
            $assign = Course::find($course_id);
           
            $assign->assigned_by_id = $assign_by;
            $assign->save();
            return response()->json(['message'=>'Course Teacher Assigned Successfully'],201);
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
    function AttendanceStudentShow($dept,$batch)
    {
        try {
            return Student::where('department_id',$dept)->where('batch_id',$batch)->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    function AttendanceStore(Request $request)
    {      

    	$this->validate($request,
            [
                'date' => 'required|date_format:Y-m-d|after_or_equal:today',
                'time' => ['required'],               
                
            ]
        ); 
        $date = $request->date;
        $time = $request->time;
        $student_id = $request->student_id; 
        $department_id = $request->department_id; 
        $batch_id = $request->batch_id; 
        $comments = $request->comments; 
        $course_id = $request->course_id; 
        $employee_id = auth()->user()->id;

        $resource = new Attendance_data();        
        $check_attendance_sql = $resource;

        $check_attendance = $check_attendance_sql->where([
            'attendance_by_id' => $employee_id,
            'date' => $date,
            'department_id' => $department_id,
            'batch_id' => $batch_id,            
            'course_id' => $course_id,
        ])->first();        
        try {
        //     DB::transaction(function () use ($request) {
                
                if (empty($check_attendance)){
                    $data = new Attendance_data();
                    $data->date= $request->date;
                    $data->time= $request->time;
                    $data->department_id= $request->department_id;
                    $data->department_name = $request->department_name;
                    $data->batch_id = $request->batch_id;                
                    $data->course_id = $request->course_id;
                    $data->course_name = $request->course_name;
                    $data->course_code = $request->course_code;
                    $data->attendance_by_id= auth()->user()->id;
                    $data->save();               
                  
                    $attendance_data_id = $data->id;
                    if (!empty($student_id)) {
                        foreach ($student_id as $key => $id) {
                            $report = new Attendance_report();                    
                            $report->attendance_data_id = $attendance_data_id;
                            $report->student_id = $id;
                            $report->comments = $comments[$key];
                            $report->save();                 
                        }                
                    }                    
                    return response()->json(['message' => 'Attendance Submited Successfully'], 201);        
    
                }else{
                    return response()->json(['message' => 'Attendance Already Submited '],200);                  
        
                }               
        
        //     });      
          
          } catch (\Exception $e) {          
              return $e->getMessage();
          }   

       
        }
        function AttendanceReport(Request $request)
        {                       
            $request->validate([
                'department' => 'required',
                'batch' => 'required',
                'course_name' => 'required',
                'date' => 'required',        
    
            ]);
            try {
                $department_id = $request->department; 
                $batch_id = $request->batch;                 
                $course_name = $request->course_name;
                $date = $request->date; 
                $report = Attendance_data::with('batch','report.student')->where([
                    'department_id' => $department_id, 
                    'batch_id' => $batch_id, 
                    'course_name' => $course_name, 
                    'date' => $date, 
                ])->get();          
              
                return $report;
              
            } catch (\Exception $e) {    
                return $e->getMessage();
            }
        }

        function AttendanceReportPrint($id)
        {  
            try {
                $report =  Attendance_data::with('batch','report.student')->find($id);                            
               $pdf = PDF::loadView('attendance_report',compact('report'));    
               return $pdf->stream('print-report.pdf');
              
            } catch (\Exception $e) {    
                return $e->getMessage();
            }
        }
  
    
}
