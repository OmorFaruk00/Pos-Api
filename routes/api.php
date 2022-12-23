<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EMP\DepartmentController;
use App\Http\Controllers\EMP\DesignationController;
// use App\Http\Controllers\EMP\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurchaseControlller;








Route::post("login", [UserController::class, 'login'])->name("login");
Route::get("password-reset/{email}", [UserController::class, 'Password_Reset']);
Route::post("password-reset-confirm/{token}", [UserController::class, 'Password_Reset_Confirm']);
Route::get("password-reset-option/{token}", [UserController::class, 'Password_Reset_Option']);
Route::post("logout", [UserController::class, 'logout'])->name("logout");
Route::post("change-password", [UserController::class, 'Change_Password']);

Route::post('test', [ProductController::class,'test']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = \App\Models\Employee::with('designation', 'department')->where('id', auth()->user()->id)->first();
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

    // Route::prefix('employee')->group(function () {
    //     Route::get("show", [EmployeeController::class, 'EmployeeShow']);
    //     Route::get("show-paginate/{item}", [EmployeeController::class, 'EmployeeShowPaginate'])->middleware('permission:Employee-show');
    //     Route::post("add", [EmployeeController::class, 'EmployeeAdd']);
    //     Route::get("edit/{id}", [EmployeeController::class, 'EmployeeEdit']);
    //     Route::post("update/{id}", [EmployeeController::class, 'EmployeeUpdate']);
    //     Route::get("status/{id}", [EmployeeController::class, 'EmployeeStatus']);
    //     Route::get("details/{id}", [EmployeeController::class, 'EmployeeDetails']);
    //     Route::get("role", [EmployeeController::class, 'EmployeeRole']);
    // });

    Route::resource('brand', Product\BrandController::class);
    Route::resource('category', Product\CategoryController::class);
    Route::resource('unit', Product\UnitController::class);
    Route::resource('product', Product\ProductController::class);
    Route::post('product-update/{id}', [ProductController::class, 'update']);
    Route::post('product-search', [ProductController::class, 'SearchProduct']);
    Route::post('product-stock', [ProductController::class, 'StockProduct']);
    Route::resource('customer-category',Customer\CustomerCategoryController::class);
    Route::resource('customer',Customer\CustomerController::class);
    Route::post('customer-update/{id}',[CustomerController::class,'update']);
    Route::post('customer-search',[CustomerController::class,'SearchCustomer']);
    Route::resource('department',Employee\DepartmentController::class);
    Route::resource('designation',Employee\DesignationController::class);
    Route::resource('employee',Employee\EmployeeController::class);
    Route::get('employee-status/{id}',[EmployeeController::class,'status']);
    Route::post('employee-get',[EmployeeController::class,'getEmployee']);
    Route::post('employee-update/{id}',[EmployeeController::class,'update']);
    Route::post('create-invoice',[PosController::class,'createInvoice']);
    Route::post('sales',[PosController::class,'salesList']);
    Route::get('sales-info/{id}',[PosController::class,'salesInfo']);
    Route::get('return-product/{item}',[PosController::class,'ReturnProduct']);
    Route::post('product-return',[PosController::class,'ReturnProductSubmit']);
    Route::post('return-list',[PosController::class,'salesReturn']);
    Route::get('return-info/{id}',[PosController::class,'salesReturnInfo']);
    Route::resource('expense-category','ExpenseCategoryController');
    Route::resource('expense','ExpenseController');
    Route::post('expense-list',[ExpenseController::class,'ExpenseList']);
    Route::get('dashboard',[DashboardController::class,'index']);
    Route::resource('supplier','SupplierController');
    Route::post('supplier-list',[SupplierController::class,'SupplierList']);
    Route::post('sales-report',[ReportController::class,'SalesReport']);
    Route::post('sales-return-report',[ReportController::class,'SalesReturnReport']);
    Route::post('expense-report',[ReportController::class,'ExpenseReport']);
    Route::post('stock-report',[ReportController::class,'StockReport']);
    Route::post('profit-loss-report',[ReportController::class,'ProfitLossReport']);
    Route::post('purchase-invoice',[PurchaseControlller::class,'PurchaseInvoice']);
    Route::post('purchase',[PurchaseControlller::class,'PurchaseList']);
    Route::get('purchase-info/{id}',[PurchaseControlller::class,'PurchaseInfo']);
    

    

   

 
  
  
   

    


});

// Route::get('pos',[PosController::class,'index']);
Route::get('/product-list',function(){
    return App\Models\Product::get();
});

