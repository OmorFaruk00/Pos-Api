<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\Employee;

class LeaveApplicationController extends Controller
{
    public function ApplicationStore(Request $request)
    {
        $request->validate([
            'kinds_of_leave' => 'required',
            'causes_of_leave' => 'required',
            'start_date' => 'required||date_format:Y-m-d|after:yesterday',
            'end_date' => 'required||date_format:Y-m-d|after:yesterday',
            'no_of_day' => 'required|numeric|min:1',
            'need_permission' => 'required',
            'in_charge' => 'required',

        ]);
        try {

            $applied_by = auth()->user()->id;
            $employee = Employee::find($applied_by);
            $approved_by = $employee->supervised_by;

            $leave = new LeaveApplication();
            $leave->kinds_of_leave = $request->kinds_of_leave;
            $leave->causes_of_leave = $request->causes_of_leave;
            $leave->start_date = $request->start_date;
            $leave->end_date = $request->end_date;
            $leave->no_of_days = $request->no_of_day;
            $leave->need_parmission = $request->need_permission;
            $leave->in_charge = $request->in_charge;
            $leave->accept_salary_difference = $request->accept_it;
            $leave->applied_by = $applied_by;
            $leave->approved_by = $approved_by;
            $leave->status = 'Pending';
            $leave->save();
            return response()->json(['message' => 'Leave Application Applied Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ApplicationPanding()
    {
        try {
            $applied_by = auth()->user()->id;
            return LeaveApplication::with('applied_by.relDesignation', 'approved_by.relDesignation')->where('applied_by', $applied_by)->where('status', "Pending")->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function ApplicationWithdraw($id)
    {
        try {
            $withdraw =  LeaveApplication::find($id);
            $withdraw->status = "Withdraw";
            $withdraw->save();
            return response()->json(['message' => 'Leave Application Widthdraw Successfully'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function ApplicationApprovalShow()
    {    
         
        try {
            $id = auth()->user()->id;
            return LeaveApplication::with('applied_by.relDesignation', 'approved_by.relDesignation')->where('approved_by',$id)->where('status','Pending')->get();           
           
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function ApplicationDeny($id)
    {
        try {
            $withdraw =  LeaveApplication::find($id);
            $withdraw->status = "Deny";
            $withdraw->save();
            return response()->json(['message' => 'Leave Application Denied'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function ApplicationApproved($id)
    {
        try {
            $withdraw =  LeaveApplication::find($id);
            $withdraw->status = "Approved";
            $withdraw->save();
            return response()->json(['message' => 'Leave Application Approved Successfull'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function ApplicationApprovedShow()
    {  
        try {
            $id = auth()->user()->id;
            return LeaveApplication::with('applied_by.relDesignation', 'approved_by.relDesignation')->where('applied_by',$id)->where('status','Approved')->get();           
           
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function ApplicationDeniedShow()
    {  
        try {
            $id = auth()->user()->id;
            return LeaveApplication::with('applied_by.relDesignation', 'approved_by.relDesignation')->where('applied_by',$id)->where('status','Deny')->get();           
           
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
