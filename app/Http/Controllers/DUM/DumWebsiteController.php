<?php

namespace App\Http\Controllers\DUM;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\BlogResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DUM\Facilitie;
use App\Models\DUM\notice;
use App\Models\DUM\Event;
use App\Models\DUM\Slider;
use App\Models\DUM\Contact;
use App\Models\DUM\TutionFee;
use App\Models\DUM\Program;
use App\Models\DUM\Blog;
use App\Models\Employee;
use App\Models\DUM\Committee;



class DumWebsiteController extends Controller
{  
    public function SliderShow()
    {
        try {
            return Slider::where('status',1)->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function FacilitieShow()
    {
        try {
            return Facilitie::where('status',1)->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function NoticeShow()
    {
        try {
            return NoticeResource::collection(notice::where('status',1)->orderBy("id","desc")->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function NoticeDetails($id)
    {
        try {
            return NoticeResource::collection(notice::where('id',$id)->where('status',1)->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function EventDetails($id)
    {
        try {
            return NoticeResource::collection(notice::where('status',1)->where('id',$id)->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function EventShow()
    {
        try {
            return EventResource::collection(Event::where('status',1)->orderBy("id","desc")->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function ProgramShow()
    {
        try {
            return Program::where('status',1)->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function TutionFeeShow()
    {
        try {
            return TutionFee::where('status',1)->get()->groupBy('type');
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function TeachingStaffShow()
    {
        try {
            return Employee::with('relDesignation','relDepartment','relSocial')->where('department_id',8)->where('status',1)->get();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function BlogShow()
    {
        try {
            return BlogResource::collection(Blog::where('status',1)->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function BlogDetails($id)
    {
        try {
            return BlogResource::collection(Blog::where('id',$id)->where('status',1)->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function CommitteeShow()
    {
        try {
            return Committee::where('status',1)->get()->groupBy('committee_type');
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }





    public function SendMessage(Request $request){
        $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|email',
            'message' => 'required',                       
            
        ]);
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->subject = $request->subject;
        $contact->email= $request->email;
        $contact->message = $request->message;
        $contact->save();
        return response()->json(['message'=>"Message Send Successfully"],200);


    }
}
