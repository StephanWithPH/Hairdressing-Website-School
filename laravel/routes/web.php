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

Route::get('/', [App\Http\Controllers\HomePageController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomePageController::class, 'index']);
Route::post('/contact/submit', [App\Http\Controllers\ContactFormController::class, 'post'])->name('submitcontactform');

Auth::routes(['register' => false]);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'loadEmployeesPage'])->name('employees')->middleware('auth');
Route::get('/employees/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'deleteEmployee'])->name('deleteemployee')->middleware('auth');
Route::get('/employees/add', [App\Http\Controllers\EmployeeController::class, 'loadAddEmployeePage'])->name('addemployee')->middleware('auth');

Route::post('/employees/add', [App\Http\Controllers\EmployeeController::class, 'submitAddEmployee'])->name('submitaddemployee')->middleware('auth');
