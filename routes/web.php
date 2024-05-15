<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OCRcontroller;
use App\Http\Controllers\BPJSController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Phh21Controller;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PphReportController;

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
    //Employee
    Route::get('/index',[HomeController::class,'index'])->name('home');
    Route::get('/employee',[EmployeeController::class,'index'])->name('employee.view');
    Route::get('/addEmployee',[EmployeeController::class,'create'])->name('addEmployee');
    Route::post('/extract-text', [OCRcontroller::class,'extractText']);
    Route::post('/storeEmployee', [EmployeeController::class,'store']);
    Route::get('/showEmployee/{id_company}', [EmployeeController::class,'show'])->name('showEmployee');
    Route::get('/export_employee/{id_company}', [EmployeeController::class,'export_employee'])->name('export_employee');
    Route::post('/employee/import_excel', [EmployeeController::class,'import_excel'])->name('import_excel');
    Route::get('/employee/{item}/edit', [EmployeeController::class,'edit'])->name('employee.edit');
    Route::put('/employee/{id_employee}',  [EmployeeController::class,'update'])->name('employee.update');

    //BPJS
    Route::get('/Bpjs',[BPJSController::class,'index'])->name('Bpjs');
    Route::get('/reportBpjsKaryawan',[BPJSController::class,'reportKaryawanIndex'])->name('reportBpjsKaryawan');
    Route::get('/reportBpjs',[BPJSController::class,'reportIndex'])->name('reportBpjs');
    Route::post('/storeBPJS', [BPJSController::class,'store'])->name('storeBPJS');
    Route::get('/showBpjs/{id_company}/{monthnum}', [BPJSController::class,'insertShow'])->name('showBpjs');
    Route::get('/reportBpjs/{id_company}/{year}', [BPJSController::class,'reportShow'])->name('reportBpjs');
    Route::get('/reportBpjsKaryawan/{id_company}/{year}', [BPJSController::class,'reportKaryawanShow'])->name('reportBpjsKaryawan');

    //PPH21
    Route::get('/pph21',[Phh21Controller::class,'index'])->name('pph21');
    Route::get('/reportPph',[Phh21Controller::class,'reportIndex'])->name('reportPph');
    Route::post('/storePph', [Phh21Controller::class,'store'])->name('storePph');
    Route::get('/showPph/{id_company}/{monthnum}/{keterangan_pph}', [Phh21Controller::class,'insertShow'])->name('showPph');
    Route::get('/reportPph/{id_company}/{monthnum}/{yearnum}', [Phh21Controller::class,'reportShow'])->name('reportPph');

    //Company
    Route::get('/company', [CompanyController::class,'index'])->name('company.view');
    Route::get('/addCompany', [CompanyController::class,'addCompany']);
    Route::post('/storeCompany', [CompanyController::class,'store']);
    Route::get('/company/{item}/edit', [CompanyController::class,'edit'])->name('company.edit');
    Route::put('/company/{company}',  [CompanyController::class,'update'])->name('company.update');
    Route::delete('company/{id_company}', [CompanyController::class,'destroy'] )->name('company.destroy');

    //Salary
    Route::get('/reportSalary',[SalaryController::class,'index'])->name('reportSalary');
    Route::get('/reportSalary/{id_company}/{year}', [SalaryController::class,'reportShow'])->name('reportSalary');

    //Report PPH
    Route::get('/reportPph21',[PphReportController::class,'index'])->name('reportPph21');
    Route::get('/reportPph21/{id_company}/{year}', [PphReportController::class,'reportShow'])->name('reportPph21');
    Route::get('/reportPphTHR',[PphReportController::class,'pphthrindex'])->name('reportPphTHR');
    Route::get('/reportPphTHR/{id_company}/{year}', [PphReportController::class,'reportPphTHRShow'])->name('reportPphTHR');
    Route::get('/reportTHR',[PphReportController::class,'thrindex'])->name('reportTHR');
    Route::get('/reportTHR/{id_company}/{year}', [PphReportController::class,'reportTHRShow'])->name('reportTHR');

    //Export
    Route::get('/exportpph21bulan/{id_company}/{month}/{year}',[Phh21Controller::class,'exportPPH'])->name('exportpph21bulan');
    Route::get('/exportpph21tahun/{id_company}/{year}',[PphReportController::class,'exportPphYearly'])->name('exportpph21tahun');
    
    Route::get('/exportpphthr/{id_company}/{year}',[PphReportController::class,'exportPPHThr'])->name('exportpphthr');
    Route::get('/exportreportthr/{id_company}/{year}',[PphReportController::class,'exportThr'])->name('exportreportthr');
    Route::get('/exportreporta1/{id_company}/{year}', [SalaryController::class, 'exportA1'])->name('export.a1');
    Route::get('/exportreporta5/{id_company}/{year}', [BPJSController::class, 'exportA5'])->name('export.a5');
    Route::get('/exportreporta10/{id_company}/{year}', [BPJSController::class, 'exportA10'])->name('export.a10');

});
