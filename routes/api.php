<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DUM\NoticeController;
use App\Http\Controllers\DUM\EventController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post("login",[UserController::class,'login'])->name("login");
Route:: post("logout",[UserController::class,'logout'])->name("logout");




Route::group(["middleware" => 'auth:sanctum'],function(){ 
    

    Route::prefix('notice')->group(function () {
        Route:: get("show",[NoticeController::class,'noticeShow']);
        Route:: post("add",[NoticeController::class,'noticeAdd']);
        Route:: get("edit/{id}",[NoticeController::class,'noticeEdit']);
        Route:: post("update/{id}",[NoticeController::class,'noticeUpdate']);
        Route:: get("status/{id}/{status}",[NoticeController::class,'noticeStatus']);
        Route:: get("delete/{id}",[NoticeController::class,'noticeDelete']);
    });
    Route::prefix('event')->group(function () {
        Route:: get("show",[EventController::class,'EventShow']);
        Route:: post("add",[EventController::class,'EventAdd']);
        Route:: get("edit/{id}",[EventController::class,'EventEdit']);
        Route:: post("update/{id}",[EventController::class,'EventUpdate']);
        Route:: get("status/{id}/{status}",[EventController::class,'EventStatus']);
        Route:: get("delete/{id}",[EventController::class,'EventDelete']);
        });
       
    
    

});