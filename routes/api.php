<?php

use App\Http\Controllers\Accounts\ClassController;
use App\Http\Controllers\Accounts\FundController;
use App\Http\Controllers\Accounts\PaymentPurposeController;
use App\Http\Controllers\Accounts\StudentCostController;
use App\Http\Controllers\Accounts\SubFundController;
use App\Http\Controllers\Accounts\TransactionController;
use App\Http\Controllers\ADM\AdmissionFormController;
use App\Http\Controllers\DUM\BlogController;
use App\Http\Controllers\DUM\CommitteeController;
use App\Http\Controllers\DUM\DumController;
use App\Http\Controllers\DUM\DumWebsiteController;
use App\Http\Controllers\DUM\EventController;
use App\Http\Controllers\DUM\FacilitieController;
use App\Http\Controllers\DUM\NoticeController;
use App\Http\Controllers\DUM\ProgramController;
use App\Http\Controllers\DUM\SliderController;
use App\Http\Controllers\DUM\TutionFeeController;
use App\Http\Controllers\EMP\DepartmentController;
use App\Http\Controllers\EMP\DesignationController;
use App\Http\Controllers\EMP\EmployeeController;
use App\Http\Controllers\Profile\QualificationController;
use App\Http\Controllers\Profile\SocialController;
use App\Http\Controllers\Profile\TrainingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADM\BatchController;
use App\Http\Controllers\ADM\SectionController;
use App\Http\Controllers\ADM\Admissioncontroller;
use App\Http\Controllers\Student\SyllabusController;
use App\Http\Controllers\Student\QuestionController;
use App\Http\Controllers\Student\LessonplanController;
use App\Http\Controllers\Student\LecturesheetController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\AttendanceController;




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




Route::get("print/{form}", [AdmissionFormController::class, 'generatePDF']);

Route::get("attendance-print", [AttendanceController::class, 'AttendanceReportPrint']);


Route::post("login", [UserController::class, 'login'])->name("login");
Route::post("logout", [UserController::class, 'logout'])->name("logout");
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return \App\Models\Employee::with('relDesignation', 'relDepartment', 'relSocial',)->where('id', auth()->user()->id)->first();
});


Route::group(["middleware" => 'auth:sanctum'], function () {
    // accounts
    Route::group(['prefix' => 'accounts', 'as' => 'account.'], function () {
        //fund
        Route::get('/funds', [FundController::class, 'index'])->name('fund.index');
        Route::post('/funds', [FundController::class, 'store'])->name('fund.store');
        Route::get('/funds-subfunds/{id}', [FundController::class, 'getSubFunds'])->name('fund.getSubFunds');

        //sub fund
        Route::get('/sub-fund', [SubFundController::class, 'index'])->name('subFund.index');
        Route::post('/sub-fund', [SubFundController::class, 'store'])->name('subFund.store');

        //transaction
        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');

        //cost
        Route::post('/costs-taking', [StudentCostController::class, 'takingCost'])->name('costs.takingCost');
        Route::post("login", [UserController::class, 'login'])->name("login");
        Route::post("logout", [UserController::class, 'logout'])->name("logout");

        Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
            return \App\Models\Employee::with('relDesignation', 'relDepartment', 'relSocial',)->where('id', auth()->user()->id)->first();
        });


        //class
        Route::get('/class', [ClassController::class, 'index'])->name('class.index');
        Route::post('/class', [ClassController::class, 'store'])->name('class.store');
        // payment purpose
        Route::get('/purpose', [PaymentPurposeController::class, 'index'])->name('payment.purpose.index');
        Route::post('/purpose', [PaymentPurposeController::class, 'store'])->name('payment.purpose.store');
        Route::get('/purpose/{classId}', [PaymentPurposeController::class, 'searchByClass'])->name('payment.searchByClass');
    });

    Route::get("profile", [ProfileController::class, 'userProfile']);
    Route::post("profile-update", [ProfileController::class, 'updateProfile']);
    Route::post("upload-profile-photo", [ProfileController::class, 'upload_profile_photo']);

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
        Route::get("show", [CommitteeController::class, 'CommitteeShow']);
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
        Route::get("print-receive/{form}", [AdmissionFormController::class, 'generatePDF']);

        Route::get("department-show", [SectionController::class, 'departmentShow']);
        Route::post("department-add", [SectionController::class, 'departmentAdd']);
        Route::get("department-edit/{id}", [SectionController::class, 'departmentEdit']);
        Route::post("department-update/{id}", [SectionController::class, 'departmentUpdate']);
        Route::get("department-status/{id}", [SectionController::class, 'departmentStatus']);
        Route::get("department-delete/{id}", [SectionController::class, 'departmentDelete']);

        Route::get("batch-show", [BatchController::class, 'batchShow']);
        Route::get("active-batch", [BatchController::class, 'activeBatchShow']);
        Route::post("batch-add", [BatchController::class, 'batchAdd']);
        Route::get("batch-edit/{id}", [BatchController::class, 'batchEdit']);
        Route::post("batch-update/{id}", [BatchController::class, 'batchUpdate']);
        Route::get("batch-status/{id}", [BatchController::class, 'batchStatus']);
        Route::get("batch-delete/{id}", [BatchController::class, 'batchDelete']);

        Route::get("department", [Admissioncontroller::class, 'activeDepartment']);
        Route::get("shift-group/{id}", [Admissioncontroller::class, 'getShiftGroup']);
        Route::post("add_student", [Admissioncontroller::class, 'admissionStore']);
        Route::get("department-wise-student/{department}/{batch}", [Admissioncontroller::class, 'departmentWiseStudent']);
        Route::get("search-student/{item}/", [Admissioncontroller::class, 'searchStudent']);
        Route::get("student-edit/{id}/", [Admissioncontroller::class, 'studentEdit']);
        Route::post("student-update/{id}/", [Admissioncontroller::class, 'studentUpdate']);
    });

    Route::prefix('course')->group(function () {
        Route::get("show", [CourseController::class, 'CourseShow']);
        Route::post("add", [CourseController::class, 'CourseAdd']);
        Route::get("edit/{id}", [CourseController::class, 'CourseEdit']);
        Route::post("update/{id}", [CourseController::class, 'CourseUpdate']);
        Route::get("delete/{id}", [CourseController::class, 'CourseDelete']);
    });

    Route::prefix('syllabus')->group(function () {
        Route::get("show", [SyllabusController::class, 'SyllabusShow']);
        Route::post("add", [SyllabusController::class, 'SyllabusAdd']);
        Route::get("edit/{id}", [SyllabusController::class, 'SyllabusEdit']);
        Route::post("update/{id}", [SyllabusController::class, 'SyllabusUpdate']);
        Route::get("delete/{id}", [SyllabusController::class, 'SyllabusDelete']);
    });
    Route::prefix('question')->group(function () {
        Route::get("show", [QuestionController::class, 'QuestionShow']);
        Route::post("add", [QuestionController::class, 'QuestionAdd']);
        Route::get("edit/{id}", [QuestionController::class, 'QuestionEdit']);
        Route::post("update/{id}", [QuestionController::class, 'QuestionUpdate']);
        Route::get("delete/{id}", [QuestionController::class, 'QuestionDelete']);
    });
    Route::prefix('lessonplan')->group(function () {
        Route::get("show", [LessonplanController::class, 'LessonShow']);
        Route::post("add", [LessonplanController::class, 'LessonAdd']);
        Route::get("edit/{id}", [LessonplanController::class, 'LessonEdit']);
        Route::post("update/{id}", [LessonplanController::class, 'LessonUpdate']);
        Route::get("delete/{id}", [LessonplanController::class, 'LessonDelete']);
    });
    Route::prefix('lecture-sheet')->group(function () {
        Route::get("show", [LecturesheetController::class, 'LectureShow']);
        Route::post("add", [LecturesheetController::class, 'LectureAdd']);
        Route::get("edit/{id}", [LecturesheetController::class, 'LectureEdit']);
        Route::post("update/{id}", [LecturesheetController::class, 'LectureUpdate']);
        Route::get("delete/{id}", [LecturesheetController::class, 'LectureDelete']);
    });
    Route::prefix('student')->group(function () {
        Route::get("show", [StudentController::class, 'studentShow']);
        Route::get("course/{id}", [StudentController::class, 'courseShow']);
        Route::get("course-code/{id}", [StudentController::class, 'courseCodeShow']);
        Route::get("attendance-show", [AttendanceController::class, 'assignedCourseShow']);
        Route::get("attendance-course/{id}", [AttendanceController::class, 'AttendanceCourseShow']);
        Route::get("attendance-student/{department}/{batch}", [AttendanceController::class, 'AttendanceStudentShow']);
        Route::post("attendance-store", [AttendanceController::class, 'AttendanceStore']);
        Route::post("attendance-report", [AttendanceController::class, 'AttendanceReport']);
        Route::get("attendance-report-print/{id}", [AttendanceController::class, 'AttendanceReportPrint']);
        Route::get("assign-course-teacher/{course_id}/{assign_by}", [AttendanceController::class, 'AssignCourseTeacher']);
        Route::get("course-show", [AttendanceController::class, 'CourseShow']);
    });

   
});
