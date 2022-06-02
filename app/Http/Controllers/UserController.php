<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use illuminate\Auth\AuthenticationException;
use App\Models\User;

class UserController extends Controller
{
    function login(Request $request){
        

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',            
        ]);
        // if(!Auth::attempt($request->only('email', 'password'))){
        //     throw new AuthenticationException('Invalid Credentials');
        //     return response()->json(['message' => 'Login Successfully'],200);
        // }

        
        $user = User::where('email',$request->email)->first();       
        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                "message" => ['These credentials do not match our records']
            ],404);
        }
        $token = $user->createToken($request->email)->plainTextToken;
        $response = [
            'user'=> $user,
            'token'=>$token
        ];
        return response($response,201);
    }
    public function logout(Request $request){
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // return response()->json(['message' => 'Logout Successfully'],200);
       
        if(auth()->check()){
            auth()->logout();
            return 'logout';
        }
    }

   



    function show(){
        return User::all();
    }
}
