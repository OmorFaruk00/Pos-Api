<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You are not authorized.'], 401);
        }
        if(!Auth::user()->role){
            return response()->json(['message' => 'You are not authorized.'], 401);
        }
        if (!$request->user()->tokenCan($permission)) {
            $permissions = Auth::user()->permissions;

            if ($permissions && !is_array($permissions)) {
                if (in_array($permission,json_decode($permissions))) {
                    return $next($request);
                }
            }
            if ($permissions && is_array($permissions)) {
                if (in_array($permission, $permissions)) {
                    return $next($request);
                }
            }
            return response()->json(['message' => 'You are not authorized.'], 401);
        }
        return $next($request);
    }
}
