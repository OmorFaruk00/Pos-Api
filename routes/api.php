<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DUM\NoticeController;
use App\Http\Controllers\DUM\EventController;
use App\Http\Controllers\DUM\FacilitieController;
use App\Http\Controllers\DUM\SliderController;
use App\Http\Controllers\DUM\ProgramController;
use App\Http\Controllers\DUM\DumController;
use App\Http\Controllers\EMP\DepartmentController;
use App\Http\Controllers\EMP\DesignationController;
use App\Http\Controllers\EMP\EmployeeController;
use App\Http\Controllers\Profile\SocialController;
use App\Http\Controllers\Profile\QualificationController;
use App\Http\Controllers\Profile\TrainingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ADM\AdmissionFormController;
use App\Http\Controllers\DUM\DumWebsiteController;
use App\Http\Controllers\DUM\TutionFeeController;
use App\Http\Controllers\DUM\BlogController;
use App\Http\Controllers\DUM\CommitteeController;




Route::post("gallery", [DumController::class, 'GalleryAdd']);



Route::get("facililies", [DumWebsiteController::class, 'FacilitieShow']);
Route::get("notice", [DumWebsiteController::class, 'NoticeShow']);
Route::get("notice-details/{id}", [DumWebsiteController::class, 'NoticeDetails']);
Route::get("event-details/{id}", [DumWebsiteController::class, 'EventDetails']);
Route::get("event", [DumWebsiteController::class, 'EventShow']);
Route::get("slider", [DumWebsiteController::class, 'SliderShow']);
Route::post("contact", [DumWebsiteController::class, 'SendMessage']);
Route::get("tution-fee", [DumWebsiteController::class, 'TutionFeeShow']);
Route::get("program", [DumWebsiteController::class, 'ProgramShow']);
Route::get("teaching-staff", [DumWebsiteController::class, 'TeachingStaffShow']);
Route::get("blog", [DumWebsiteController::class, 'BlogShow']);
Route::get("blog-details/{id}", [DumWebsiteController::class, 'BlogDetails']);
Route::get("committee", [DumWebsiteController::class, 'CommitteeShow']);
Route::get("gallery", [DumWebsiteController::class, 'galleryShow']);












Route::post("login", [UserController::class, 'login'])->name("login");
Route::post("logout", [UserController::class, 'logout'])->name("logout");
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {    
    return \App\Models\Employee::with('relDesignation','relDepartment','relSocial',)->where('id',auth()->user()->id)->first();   
   
});
Route::group(["middleware" => 'auth:sanctum'], function () {
    Route::get("profile", [ProfileController::class, 'userProfile']);
    Route::prefix('notice')->group(function () {
        Route::get("show", [NoticeController::class, 'noticeShow']);
        Route::post("add", [NoticeController::class, 'noticeAdd']);
        Route::get("edit/{id}", [NoticeController::class, 'noticeEdit']);
        Route::post("update/{id}", [NoticeController::class, 'noticeUpdate']);
        Route::get("status/{id}", [NoticeController::class, 'noticeStatus']);
        Route::get("delete/{id}", [NoticeController::class, 'noticeDelete']);
    });
    Route::prefix('event')->group(function () {
        Route::get("show", [EventController::class, 'EventShow']);
        Route::post("add", [EventController::class, 'EventAdd']);
        Route::get("edit/{id}", [EventController::class, 'EventEdit']);
        Route::post("update/{id}", [EventController::class, 'EventUpdate']);
        Route::get("status/{id}", [EventController::class, 'EventStatus']);
        Route::get("delete/{id}", [EventController::class, 'EventDelete']);
    });
    Route::prefix('facilitie')->group(function () {
        Route::get("show", [FacilitieController::class, 'FacilitieShow']);
        Route::post("add", [FacilitieController::class, 'FacilitieAdd']);
        Route::get("edit/{id}", [FacilitieController::class, 'FacilitieEdit']);
        Route::post("update/{id}", [FacilitieController::class, 'FacilitieUpdate']);
        Route::get("status/{id}", [FacilitieController::class, 'FacilitieStatus']);
        Route::get("delete/{id}", [FacilitieController::class, 'FacilitieDelete']);
    });
    Route::prefix('slider')->group(function () {
        Route::get("show", [SliderController::class, 'SliderShow']);
        Route::post("add", [SliderController::class, 'SliderAdd']);
        Route::get("edit/{id}", [SliderController::class, 'SliderEdit']);
        Route::post("update/{id}", [SliderController::class, 'SliderUpdate']);
        Route::get("status/{id}", [SliderController::class, 'SliderStatus']);
        Route::get("delete/{id}", [SliderController::class, 'SliderDelete']);
    });
    Route::prefix('program')->group(function () {
        Route::get("show", [ProgramController::class, 'ProgramShow']);
        Route::post("add", [ProgramController::class, 'ProgramAdd']);
        Route::get("edit/{id}", [ProgramController::class, 'ProgramEdit']);
        Route::post("update/{id}", [ProgramController::class, 'ProgramUpdate']);
        Route::get("status/{id}", [ProgramController::class, 'ProgramStatus']);
        Route::get("delete/{id}", [ProgramController::class, 'ProgramDelete']);
    });
    Route::prefix('tution')->group(function () {       
        Route::get("show", [TutionFeeController::class, 'TutionFeeShow']);
        Route::post("add", [TutionFeeController::class, 'TutionFeeAdd']);
        Route::get("edit/{id}", [TutionFeeController::class, 'TutionFeeEdit']);
        Route::post("update/{id}", [TutionFeeController::class, 'TutionFeeUpdate']);
        Route::get("delete/{id}", [TutionFeeController::class, 'TutionFeeDelete']);
        Route::get("status/{id}", [TutionFeeController::class, 'TutionFeeStatus']);
       
    });
    Route::prefix('blog')->group(function () {       
        Route::get("show", [BlogController::class, 'BlogShow']);
        Route::post("add", [BlogController::class, 'BlogAdd']);
        Route::get("edit/{id}", [BlogController::class, 'BlogEdit']);
        Route::post("update/{id}", [BlogController::class, 'BlogUpdate']);
        Route::get("delete/{id}", [BlogController::class, 'BlogDelete']);
        Route::get("status/{id}", [BlogController::class, 'BlogStatus']);
       
    });
    Route::prefix('committee')->group(function () {       
        Route::get("show",[CommitteeController::class, 'CommitteeShow']);
        Route::post("add", [CommitteeController::class, 'CommitteeAdd']);
        Route::get("edit/{id}", [CommitteeController::class, 'CommitteeEdit']);
        Route::post("update/{id}", [CommitteeController::class, 'CommitteeUpdate']);
        Route::get("delete/{id}", [CommitteeController::class, 'CommitteeDelete']);
        Route::get("status/{id}", [CommitteeController::class, 'CommitteeStatus']);
       
    });
    Route::get("contact/show", [DumController::class, 'ContactShow']);
    Route::post("gallery/add", [DumController::class, 'GalleryAdd']);

    Route::prefix('department')->group(function () {
        Route::get("show", [DepartmentController::class, 'DepartmentShow']);
        Route::post("add", [DepartmentController::class, 'DepartmentAdd']);
        Route::get("edit/{id}", [DepartmentController::class, 'DepartmentEdit']);
        Route::post("update/{id}", [DepartmentController::class, 'DepartmentUpdate']);
        Route::get("status/{id}", [DepartmentController::class, 'DepartmentStatus']);
        Route::get("delete/{id}", [DepartmentController::class, 'DepartmentDelete']);
    });
    Route::prefix('designation')->group(function () {
        Route::get("show", [DesignationController::class, 'DesignationShow']);
        Route::post("add", [DesignationController::class, 'DesignationAdd']);
        Route::get("edit/{id}", [DesignationController::class, 'DesignationEdit']);
        Route::post("update/{id}", [DesignationController::class, 'DesignationUpdate']);
        Route::get("status/{id}", [DesignationController::class, 'DesignationStatus']);
        Route::get("delete/{id}", [DesignationController::class, 'DesignationDelete']);
    });
    Route::prefix('employee')->group(function () {
        Route::get("show", [EmployeeController::class, 'EmployeeShow']);
        Route::post("add", [EmployeeController::class, 'EmployeeAdd']);
        Route::get("edit/{id}", [EmployeeController::class, 'EmployeeEdit']);
        Route::post("update/{id}", [EmployeeController::class, 'EmployeeUpdate']);
        Route::get("status/{id}", [EmployeeController::class, 'EmployeeStatus']);
        Route::get("delete/{id}", [EmployeeController::class, 'EmployeeDelete']);
        Route::get("details/{id}", [EmployeeController::class, 'EmployeeDetails']);
    });
    Route::prefix('social')->group(function () {       
        Route::get("show", [SocialController::class, 'SocialShow']);
        Route::post("add", [SocialController::class, 'SocialAdd']);
        Route::get("edit/{id}", [SocialController::class, 'SocialEdit']);
        Route::post("update/{id}", [SocialController::class, 'SocialUpdate']);
        Route::get("delete/{id}", [SocialController::class, 'SocialDelete']);       
    });
    Route::prefix('qualification')->group(function () {       
        Route::get("show", [QualificationController::class, 'QualificationShow']);
        Route::post("add", [QualificationController::class, 'QualificationAdd']);
        Route::get("edit/{id}", [QualificationController::class, 'QualificationEdit']);
        Route::post("update/{id}", [QualificationController::class, 'QualificationUpdate']);
        Route::get("delete/{id}", [QualificationController::class, 'QualificationDelete']);
       
    });
    Route::prefix('training')->group(function () {       
        Route::get("show", [TrainingController::class, 'TrainingShow']);
        Route::post("add", [TrainingController::class, 'TrainingAdd']);
        Route::get("edit/{id}", [TrainingController::class, 'TrainingEdit']);
        Route::post("update/{id}", [TrainingController::class, 'TrainingUpdate']);
        Route::get("delete/{id}", [TrainingController::class, 'TrainingDelete']);
       
    });
 
    Route::prefix('admission')->group(function () { 
        Route::post("form-import", [AdmissionFormController::class, 'importForm']);      
        Route::get("form-stock", [AdmissionFormController::class, 'stockForm']);      
        Route::get("form-search/{form}", [AdmissionFormController::class, 'searchForm']);      
        Route::get("department", [AdmissionFormController::class, 'getDepartment']);      
        Route::get("batch/{id}", [AdmissionFormController::class, 'getBatch']);      
        Route::post("form-sales/{form}", [AdmissionFormController::class, 'formSale']); 
        Route::get("print-receive", [AdmissionFormController::class, 'generatePDF']); 
             
       
       
    });

});
