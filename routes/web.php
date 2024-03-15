<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OCRcontroller;
use App\Http\Controllers\BPJSController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// })->name('index');

// Route::get('/welcome',[c::class,'index'])->name('login');
Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/login-process',[LoginController::class,'login_process'])->name('login-process');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-store',[LoginController::class,'register_process'])->name('register-store');
Route::get('/passwordReset', [LoginController::class, 'passwordReset'])->name('passwordReset');
Route::post('/passwordResetAct', [LoginController::class, 'forgot_password_act'])->name('passwordResetAct');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/index',[HomeController::class,'index'])->name('home');
    Route::get('/Employee',[EmployeeController::class,'index'])->name('Employee');
    Route::get('/addEmployee',[EmployeeController::class,'create'])->name('addEmployee');
    Route::post('/extract-text', [OCRcontroller::class,'extractText']);
    Route::post('/storeEmployee', [EmployeeController::class,'store']);  
    Route::get('/Bpjs',[BPJSController::class,'index'])->name('Bpjs');
    Route::post('/storeBPJS', [BPJSController::class,'store'])->name('storeBPJS'); 
    Route::get('/showBpjs/{id_company}', [BPJSController::class,'insertShow'])->name('showBpjs'); 

    Route::get('/company', [CompanyController::class,'index'])->name('company.view');
    Route::get('/addCompany', [CompanyController::class,'addCompany']);
    Route::post('/storeCompany', [CompanyController::class,'store']);    
    Route::get('/company/{item}/edit', [CompanyController::class,'edit'])->name('company.edit');
    Route::put('/company/{company}',  [CompanyController::class,'update'])->name('company.update');
    Route::delete('company/{id_company}', [CompanyController::class,'destroy'] )->name('company.destroy');
});


