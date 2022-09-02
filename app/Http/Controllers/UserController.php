<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use illuminate\Auth\AuthenticationException;
use App\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Password_reset;
use Carbon\Carbon;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            $user = Employee::where('email', $request->email)->where('status', 1)->first();
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
            $token = $user->createToken($request->email, $role ? $role->permissions : [])->plainTextToken;
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
            $request->user()->currentAccessToken()->delete();
            auth()->logout();
        }
        return response([
            "message" => 'Logout Successfull.'
        ], 200);
    }

    public function Change_Password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);
        try {
            $id = auth()->user()->id;
            $user = Employee::where('id', $id)->first();
            if (!Hash::check($request->old_password, $user->password)) {
                return response([
                    "message" => 'The given password is invalid.', 'status' => 203
                ]);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return response(['message' => 'Password Change Successfully', 'status' => 201]);
        } catch (AuthenticationException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    public function Password_Reset(Request $request, $email)
    {
        try {
            $user = Employee::where('email', $email)->first();
            if (!$user) {
                return response(['message' => 'Email doesnt exists', 'status' => 404]);
            }

            $token = Str::random(50);
            Password_reset::create([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('reset', ['token' => $token], function ($message) use ($email) {
                $message->subject('Password Reset');
                $message->to($email);
            });
            return response(['message' => 'Password Reset Email Send... Check Your Email', 'status' => 200]);
        } catch (AuthenticationException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    public function Password_Reset_Confirm(Request $request, $token)
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);
        try {
            // $formatted = Carbon::now()->subMinute(1)->toDateTimeString();
            // Password_reset::where('created_at', '<=', $formatted)->delete();

            $PasswordReset = Password_reset::where('token', $token)->first();
            if (!$PasswordReset) {
                return response(['message' => 'Token is Invalid or Expired', 'status' => 404]);
            }
            $user = Employee::where('email', $PasswordReset->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            $PasswordReset = Password_reset::where('email', $user->email)->delete();

            return response(['message' => 'Password Reset Successfully', 'status' => 201]);
        } catch (AuthenticationException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    public function Password_Reset_Option($token){
        return view('password-reset-option',compact('token'));

    }
   
}
