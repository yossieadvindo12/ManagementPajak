<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OCRcontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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
    Route::get('/addEmployee',[HomeController::class,'addEmployee'])->name('addEmployee');
});

Route::post('/extract-text', [OCRcontroller::class,'extractText']);

