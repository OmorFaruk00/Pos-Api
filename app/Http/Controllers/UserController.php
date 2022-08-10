<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use illuminate\Auth\AuthenticationException;
use App\Models\Employee;
use App\Models\Role;

class UserController extends Controller
{
    function login(Request $request)
    {


        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            $user = Employee::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 203);
            }
            if (!Hash::check($request->password, $user->password)) {
                return response([
                    "message" => 'The given password is invalid.'
                ], 203);
            }
            if ($user->role) {
                $role = Role::where('name', $user->role)->first();
            }
            $token = $user->createToken($request->email, $role?$role->permissions:[])->plainTextToken;            
            $response = [
                'user' => $user,
                'token' => $token,
                
            ];
            return response($response, 201);
        } catch (AuthenticationException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    public function logout(Request $request)
    {

        if (auth()->check()) {
            auth()->logout();
            return 'logout';
        }
    }
}
