<?php

use Illuminate\Support\Facades\Route;

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

/* User side */
Route::get('/', [App\Http\Controllers\HomePageController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomePageController::class, 'index']);
Route::post('/contact/submit', [App\Http\Controllers\ContactFormController::class, 'post'])->name('submitcontactform');

/* Auth routes */
Auth::routes(['register' => false]);

/* Dashboard */
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


/* Employees */
Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'loadEmployeesPage'])->name('employees')->middleware(['auth', 'role:owner']);
Route::get('/employees/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'deleteEmployee'])->name('deleteemployee')->middleware(['auth', 'role:owner']);
Route::get('/employees/add', [App\Http\Controllers\EmployeeController::class, 'loadAddEmployeePage'])->name('addemployee')->middleware(['auth', 'role:owner']);

Route::post('/employees/add', [App\Http\Controllers\EmployeeController::class, 'submitAddEmployee'])->name('submitaddemployee')->middleware(['auth', 'role:owner']);



/* Treatments */
Route::get('/treatments', [App\Http\Controllers\TreatmentController::class, 'loadTreatmentsPage'])->name('treatments')->middleware(['auth', 'role:owner']);
Route::get('/treatments/delete/{id}', [App\Http\Controllers\TreatmentController::class, 'deleteTreatment'])->name('deletetreatment')->middleware(['auth', 'role:owner']);
Route::get('/treatments/edit/{id}', [App\Http\Controllers\TreatmentController::class, 'loadEditTreatmentPage'])->name('edittreatment')->middleware(['auth', 'role:owner']);
Route::get('/treatments/add', [App\Http\Controllers\TreatmentController::class, 'loadAddTreatmentPage'])->name('addtreatment')->middleware(['auth', 'role:owner']);

Route::post('/treatments/submit', [App\Http\Controllers\TreatmentController::class, 'submitTreatment'])->name('submittreatment')->middleware(['auth', 'role:owner']);
