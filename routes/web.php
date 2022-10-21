<?php


use Illuminate\Support\Facades\Route;
// namespace App\Models;
use App\Models\user;
use App\Http\Controllers\ADM\AdmissionFormController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function () {
    return user::all();
});
Route::get('sale','PosController@test');
Route::get("test", [AdmissionFormController::class, 'testPDF']); 