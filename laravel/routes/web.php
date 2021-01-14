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
//Route::get('/home', [App\Http\Controllers\HomePageController::class, 'index']);
Route::post('/contact/submit', [App\Http\Controllers\ContactFormController::class, 'post'])->name('submitcontactform');

/* Auth routes */
Auth::routes(['register' => false]);

/* Dashboard */
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/appointments', [App\Http\Controllers\AppointmentsController::class, 'loadAppointmentsPage'])->name('appointments')->middleware('auth');

/* Employees */
Route::get('/dashboard/employees', [App\Http\Controllers\EmployeeController::class, 'loadEmployeesPage'])->name('employees')->middleware(['auth', 'role:owner']);
Route::get('/dashboard/employees/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'deleteEmployee'])->name('deleteemployee')->middleware(['auth', 'role:owner']);
Route::get('/dashboard/employees/edit/{id}', [App\Http\Controllers\EmployeeController::class, 'loadEditEmployeePage'])->name('editemployee')->middleware(['auth', 'role:owner']);

Route::get('/dashboard/employees/add', [App\Http\Controllers\EmployeeController::class, 'loadAddEmployeePage'])->name('addemployee')->middleware(['auth', 'role:owner']);

Route::post('/dashboard/employees/submit', [App\Http\Controllers\EmployeeController::class, 'submitEmployee'])->name('submitemployee')->middleware(['auth', 'role:owner']);



/* Treatments */
Route::get('/dashboard/treatments', [App\Http\Controllers\TreatmentController::class, 'loadTreatmentsPage'])->name('treatments')->middleware(['auth', 'role:owner']);
Route::get('/dashboard/treatments/delete/{id}', [App\Http\Controllers\TreatmentController::class, 'deleteTreatment'])->name('deletetreatment')->middleware(['auth', 'role:owner']);
Route::get('/dashboard/treatments/edit/{id}', [App\Http\Controllers\TreatmentController::class, 'loadEditTreatmentPage'])->name('edittreatment')->middleware(['auth', 'role:owner']);
Route::get('/dashboard/treatments/add', [App\Http\Controllers\TreatmentController::class, 'loadAddTreatmentPage'])->name('addtreatment')->middleware(['auth', 'role:owner']);

Route::post('/dashboard/treatments/submit', [App\Http\Controllers\TreatmentController::class, 'submitTreatment'])->name('submittreatment')->middleware(['auth', 'role:owner']);

/* Appointments */
Route::post('/dashboard/appointments/submit', [App\Http\Controllers\AppointmentsController::class, 'submitAppointment'])->name('submitappointment');
Route::get('/dashboard/appointments/edit/{id}', [App\Http\Controllers\AppointmentsController::class, 'loadEditAppointmentPageAdmin'])->name('editappointmentadmin')->middleware(['auth']);
Route::post('/dashboard/appointments/submit/admin', [App\Http\Controllers\AppointmentsController::class, 'submitAppointmentAdmin'])->name('submitappointmentadmin')->middleware(['auth']);
Route::get('/dashboard/appointments/cancel/{id}', [App\Http\Controllers\AppointmentsController::class, 'deleteAppointment'])->name('deleteappointment')->middleware(['auth']);

/* Customer appointment editing */
Route::get('/appointment/edit/{id}', [App\Http\Controllers\AppointmentsController::class, 'loadEditAppointmentPage'])->name('editappointment')->middleware(['auth']);
