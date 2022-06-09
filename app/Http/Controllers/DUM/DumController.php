<?php

namespace App\Http\Controllers\DUM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DUM\Contact;

class DumController extends Controller
{
    function ContactShow(){
        return Contact::all();
       
       
        
        
    }
}
