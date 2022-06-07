<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DUM\NoticeController;
use App\Http\Controllers\DUM\EventController;
use App\Http\Controllers\DUM\FacilitieController;
use App\Http\Controllers\DUM\SliderController;
use App\Http\Controllers\DUM\ProgramController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post("login", [UserController::class, 'login'])->name("login");
Route::post("logout", [UserController::class, 'logout'])->name("logout");




Route::group(["middleware" => 'auth:sanctum'], function () {


    Route::prefix('notice')->group(function () {
        Route::get("show", [NoticeController::class, 'noticeShow']);
        Route::post("add", [NoticeController::class, 'noticeAdd']);
        Route::get("edit/{id}", [NoticeController::class, 'noticeEdit']);
        Route::post("update/{id}", [NoticeController::class, 'noticeUpdate']);
        Route::get("status/{id}/{status}", [NoticeController::class, 'noticeStatus']);
        Route::get("delete/{id}", [NoticeController::class, 'noticeDelete']);
    });
    Route::prefix('event')->group(function () {
        Route::get("show", [EventController::class, 'EventShow']);
        Route::post("add", [EventController::class, 'EventAdd']);
        Route::get("edit/{id}", [EventController::class, 'EventEdit']);
        Route::post("update/{id}", [EventController::class, 'EventUpdate']);
        Route::get("status/{id}/{status}", [EventController::class, 'EventStatus']);
        Route::get("delete/{id}", [EventController::class, 'EventDelete']);
    });
    Route::prefix('facilitie')->group(function () {
        Route::get("show", [FacilitieController::class, 'FacilitieShow']);
        Route::post("add", [FacilitieController::class, 'FacilitieAdd']);
        Route::get("edit/{id}", [FacilitieController::class, 'FacilitieEdit']);
        Route::post("update/{id}", [FacilitieController::class, 'FacilitieUpdate']);
        Route::get("status/{id}/{status}", [FacilitieController::class, 'FacilitieStatus']);
        Route::get("delete/{id}", [FacilitieController::class, 'FacilitieDelete']);
    });

    Route::prefix('slider')->group(function () {
        Route::get("show", [SliderController::class, 'SliderShow']);
        Route::post("add", [SliderController::class, 'SliderAdd']);
        Route::get("edit/{id}", [SliderController::class, 'SliderEdit']);
        Route::post("update/{id}", [SliderController::class, 'SliderUpdate']);
        Route::get("status/{id}/{status}", [SliderController::class, 'SliderStatus']);
        Route::get("delete/{id}", [SliderController::class, 'SliderDelete']);
    });
    Route::prefix('program')->group(function () {
        Route::get("show", [ProgramController::class, 'ProgramShow']);
        Route::post("add", [ProgramController::class, 'ProgramAdd']);
        Route::get("edit/{id}", [ProgramController::class, 'ProgramEdit']);
        Route::post("update/{id}", [ProgramController::class, 'ProgramUpdate']);
        Route::get("status/{id}/{status}", [ProgramController::class, 'ProgramStatus']);
        Route::get("delete/{id}", [ProgramController::class, 'ProgramDelete']);
    });
});
