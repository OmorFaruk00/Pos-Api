<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EMP\DepartmentController;
use App\Http\Controllers\EMP\DesignationController;
use App\Http\Controllers\EMP\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\UnitController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Customer\CustomerCategoryController;







Route::post("login", [UserController::class, 'login'])->name("login");
Route::get("password-reset/{email}", [UserController::class, 'Password_Reset']);
Route::post("password-reset-confirm/{token}", [UserController::class, 'Password_Reset_Confirm']);
Route::get("password-reset-option/{token}", [UserController::class, 'Password_Reset_Option']);
Route::post("logout", [UserController::class, 'logout'])->name("logout");
Route::post("change-password", [UserController::class, 'Change_Password']);

Route::post('test', [ProductController::class,'test']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = \App\Models\Employee::with('relDesignation', 'relDepartment')->where('id', auth()->user()->id)->first();
    if ($user->role) {
        $role = \App\Models\Role::where('name', $user->role)->first();
    }
    $parmission = $role->permissions ?? [];
    $special_parmission = $user->permissions ?? [];
    $user['permission'] = array_merge($parmission, $special_parmission);
    return $user;
});
Route::group(["middleware" => 'auth:sanctum'], function () {
    Route::group(['as' => 'setting.', 'prefix' => 'setting', 'middleware' => 'permission:Permission'], function () {
        Route::get('roles/{id}', [SettingController::class, 'roleEdit'])->name('roles.edit');
        Route::get('roles', [SettingController::class, 'getRole'])->name('roles.show');
        Route::post('role', [SettingController::class, 'storeRole'])->name('roles.store');
        Route::post('role/{id}', [SettingController::class, 'updateRoleInfo'])->name('roles.update');
        Route::post('assign-role/{id}', [SettingController::class, 'updateRole'])->name('roles.assignRole');
        Route::get('permissions', [SettingController::class, 'getPermission'])->name('roles.permission');
        Route::get('permission/{id}', [SettingController::class, 'getPermissionInfo'])->name('roles.permissionInfo');
        Route::post('permission/{id}', [SettingController::class, 'updatePermissionInfo'])->name('roles.updatePermissionInfo');
        Route::post('permission', [SettingController::class, 'storePermission'])->name('roles.permission.store');
        Route::post('special-permission/{id}', [SettingController::class, 'specialPermission'])->name('roles.specialPermission');
    });
    // accounts  

    Route::group(['prefix' => 'department', 'middleware' => 'permission:Department'], function () {
        Route::get("show", [DepartmentController::class, 'DepartmentShow']);
        Route::post("add", [DepartmentController::class, 'DepartmentAdd']);
        Route::get("edit/{id}", [DepartmentController::class, 'DepartmentEdit']);
        Route::post("update/{id}", [DepartmentController::class, 'DepartmentUpdate']);
        Route::get("status/{id}", [DepartmentController::class, 'DepartmentStatus']);
        Route::get("delete/{id}", [DepartmentController::class, 'DepartmentDelete']);
    });

    Route::group(['prefix' => 'designation', 'middleware' => 'permission:Designation'], function () {
        Route::get("show", [DesignationController::class, 'DesignationShow']);
        Route::post("add", [DesignationController::class, 'DesignationAdd']);
        Route::get("edit/{id}", [DesignationController::class, 'DesignationEdit']);
        Route::post("update/{id}", [DesignationController::class, 'DesignationUpdate']);
        Route::get("status/{id}", [DesignationController::class, 'DesignationStatus']);
        Route::get("delete/{id}", [DesignationController::class, 'DesignationDelete']);
    });
    Route::prefix('employee')->group(function () {
        Route::get("show", [EmployeeController::class, 'EmployeeShow']);
        Route::get("show-paginate/{item}", [EmployeeController::class, 'EmployeeShowPaginate'])->middleware('permission:Employee-show');
        Route::post("add", [EmployeeController::class, 'EmployeeAdd'])->middleware('permission:Employee-add');
        Route::get("edit/{id}", [EmployeeController::class, 'EmployeeEdit']);
        Route::post("update/{id}", [EmployeeController::class, 'EmployeeUpdate'])->middleware('permission:Employee-update');
        Route::get("status/{id}", [EmployeeController::class, 'EmployeeStatus'])->middleware('permission:Employee-status');
        Route::get("details/{id}", [EmployeeController::class, 'EmployeeDetails']);
        Route::get("role", [EmployeeController::class, 'EmployeeRole']);
    });

    Route::resource('brand', Product\BrandController::class);
    Route::resource('category', Product\CategoryController::class);
    Route::resource('unit', Product\UnitController::class);
    Route::resource('product', Product\ProductController::class);
    Route::resource('customer-category',Customer\CustomerCategoryController::class);
    Route::post('products/update/{id}', [ProductController::class, 'update']);
    Route::post('product-search', [ProductController::class, 'SearchProduct']);
    

    

   

 
  
  
   

    


});

