<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getRole()
    {
        return Role::all();
    }
    public function getPermission()
    {
        return Permission::all();
    }
    public function storeRole(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name|distinct',
        ],[
            'permissions.*.distinct' => 'The :attribute field must not have repetive values.',
            'permissions.*.exists' => 'The :attribute field must have a valid value.',
        ]);
        Role::create([
            'name' => $req->name,
            'permissions' => json_encode($req->permissions)
        ]);
        return response()->json(['message' => 'Role created successfully']);
    }
    public function storePermission(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:permissions,name',
        ]);
        Permission::create([
            'name' => $req->name,
        ]);
        return response()->json(['message' => 'Permission created successfully']);
    }
    public function updateRole(Request $req, $id)
    {
        $req->validate([
            'role' => 'required|exists:roles,name',
        ]);
        $user = Employee::findOrFail($id);
        $user->role = $req->role;
        $user->save();
        return response()->json(['message' => 'Role updated successfully']);
    }
    public function specialPermission(Request $req, $id)
    {
        $req->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ]);
        $user = Employee::findOrFail($id);
        $user->permissions = json_encode($req->permissions);
        $user->save();
        return response()->json(['message' => 'Special Permission Given successfully']);
    }
}
