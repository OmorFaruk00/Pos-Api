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
    public function getPermissionInfo($id)
    {
        return Permission::findOrFail($id);
    }
    public function storeRole(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name|distinct',
        ],[
            'permissions.*.distinct' => 'The :attribute field must not have repetive values.',
            'permissions.*.exists' => 'The :attribute field must have a valid value.',
        ]);
        Role::create([
            'name' => $req->name,
            'permissions' => $req->permissions
        ]);
        return response()->json(['message' => 'Role created successfully']);
    }
    public function updateRoleInfo(Request $req,$id)
    {
        $req->validate([
            'name' => 'required|unique:roles,name,'.$req->id,
            'permissions' => 'required|array',
            'permissions.*' => 'required',
        ]);
        $role=Role::findOrFail($id);
        $role->update([
            'name' => $req->name,
            'permissions' => $req->permissions
        ]);
        $role->save();
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
    public function updatePermissionInfo(Request $req,$id)
    {
        $req->validate([
            'name' => 'required|unique:permissions,name,'.$req->id,
        ]);
        $permission=Permission::findOrFail($id);
        $permission->update([
            'name' => $req->name,
        ]);
        $permission->save();
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
        $user->permissions = $req->permissions;
        $user->save();
        return response()->json(['message' => 'Special Permission Given successfully']);
    }
    public function roleEdit($id){
        $role = Role::findOrFail($id);
        return response()->json($role);
    }
}
