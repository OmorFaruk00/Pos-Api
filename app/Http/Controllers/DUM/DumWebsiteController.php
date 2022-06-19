<?php

namespace App\Http\Controllers\DUM;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\EventResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DUM\Facilitie;
use App\Models\DUM\notice;
use App\Models\DUM\Event;
use App\Models\DUM\Slider;
use App\Models\DUM\Contact;
use App\Models\DUM\TutionFee;


class DumWebsiteController extends Controller
{  
    public function SliderShow()
    {
        try {
            return Slider::all();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function FacilitieShow()
    {
        try {
            return Facilitie::all();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function NoticeShow()
    {
        try {
            return NoticeResource::collection(notice::orderBy("id","desc")->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function NoticeDetails($id)
    {
        try {
            return NoticeResource::collection(notice::where('id',$id)->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function EventDetails($id)
    {
        try {
            return NoticeResource::collection(notice::where('id',$id)->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function EventShow()
    {
        try {
            return EventResource::collection(Event::orderBy("id","desc")->get());
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function TutionFeeShow()
    {
        try {
            return TutionFee::get()->groupBy('type');
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
