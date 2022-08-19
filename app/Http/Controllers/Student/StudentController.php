<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Accounts\StudentCost;
use App\Models\Student;

class StudentController extends Controller
{
    function studentShow()
    {
        try {
            return Student::with('department', 'batch')->paginate('5');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function courseShow($id)
    {
        try {
            return Course::where('department_id', $id)->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function courseCodeShow($item)
    {
        try {
            // return $id;
            return Course::where('course_name', $item)->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function studentStatement($sid)
    {
        // all summery
        $scost = StudentCost::whereHas('transactionable')->with(['relFeeType:id,name,amount', 'transactionable' => function ($query) {
            return $query->select('id', 'amount', 'type', 'trans_type', 'lilha_pay', 'scholarship', 'scholarship_type', 'transactionable_type', 'transactionable_id');
        }, 'relBatch:id,tution_fee,common_scholarship'])->where('student_id', $sid)->get();
        $student = Student::with('batch')->where('id',  $sid)->firstOrFail();
        $total_scholarship = $scost->sum('scholarship');
        $common_scholarship = $student->batch->common_scholarship;
        $summary = [];
        $summary['total_fee'] = (int)$student->batch->tution_fee;
        $summary['total_scholarship'] = $total_scholarship + $common_scholarship;
        $moneyGiven = $scost->sum('amount') - ((int)$scost->sum('transactionable.lilha_pay') + (int)$scost->sum('scholarship'));
        $summary['total_paid'] = $moneyGiven;
        $currentDue = (int)$summary['total_fee'] - (int)$summary['total_scholarship'] - (int)$summary['total_paid'];
        $summary['current_due'] = $currentDue > 0 ? $currentDue : 0;
        return response(['total' => $scost, 'summary' => $summary]);
    }
}
