<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Public Career Board (Guest Accessible)
Route::get('/careers', [\App\Http\Controllers\CareersController::class, 'index'])->name('careers.index');
Route::get('/careers/{id}', [\App\Http\Controllers\CareersController::class, 'show'])->name('careers.show');
Route::post('/careers/{id}/apply', [\App\Http\Controllers\CareersController::class, 'apply'])->name('careers.apply');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Core HR Module Routes
    Route::resource('companies', \App\Http\Controllers\CompanyController::class);
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('sub_departments', \App\Http\Controllers\SubDepartmentController::class);
    Route::resource('designations', \App\Http\Controllers\DesignationController::class);
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);

    // Dynamic Cascading Utility Routes
    Route::get('get-departments/{company_id}', [\App\Http\Controllers\CompanyController::class, 'getDepartments'])->name('get.departments');
    Route::get('get-designations/{department_id}', [\App\Http\Controllers\DepartmentController::class, 'getDesignations'])->name('get.designations');
    Route::get('get-sub-departments/{department_id}', [\App\Http\Controllers\SubDepartmentController::class, 'getSubDepartments'])->name('get.sub_departments');

    // Employee Profile Addons (Qualifications, Experience, Contacts)
    Route::post('save-qualification', [\App\Http\Controllers\EmployeeAddonController::class, 'saveQualification'])->name('save.qualification');
    Route::delete('delete-qualification/{id}', [\App\Http\Controllers\EmployeeAddonController::class, 'deleteQualification'])->name('delete.qualification');
    Route::post('save-experience', [\App\Http\Controllers\EmployeeAddonController::class, 'saveExperience'])->name('save.experience');
    Route::delete('delete-experience/{id}', [\App\Http\Controllers\EmployeeAddonController::class, 'deleteExperience'])->name('delete.experience');
    Route::post('save-contact', [\App\Http\Controllers\EmployeeAddonController::class, 'saveContact'])->name('save.contact');
    Route::delete('delete-contact/{id}', [\App\Http\Controllers\EmployeeAddonController::class, 'deleteContact'])->name('delete.contact');

    // Access Control Management (Strictly for Super Admins)
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::resource('roles', \App\Http\Controllers\RoleController::class);
        Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    });

    // Attendance Management
    Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance/data', [\App\Http\Controllers\AttendanceController::class, 'data'])->name('attendance.data');

    // Leave Management
    Route::get('admin/leaves', [\App\Http\Controllers\LeaveController::class, 'index'])->name('leaves.index');
    Route::post('admin/leaves/data', [\App\Http\Controllers\LeaveController::class, 'data'])->name('leaves.data');
    Route::post('admin/leaves/store', [\App\Http\Controllers\LeaveController::class, 'store'])->name('leaves.store');
    Route::post('admin/leaves/{id}/update-status', [\App\Http\Controllers\LeaveController::class, 'updateStatus'])->name('leaves.update_status');

    // Leave Types Management
    Route::get('admin/leave-types', [\App\Http\Controllers\LeaveTypeController::class, 'index'])->name('leave_types.index');
    Route::post('admin/leave-types', [\App\Http\Controllers\LeaveTypeController::class, 'store'])->name('leave_types.store');
    Route::post('admin/leave-types/{id}/update', [\App\Http\Controllers\LeaveTypeController::class, 'update'])->name('leave_types.update');
    Route::delete('admin/leave-types/{id}', [\App\Http\Controllers\LeaveTypeController::class, 'destroy'])->name('leave_types.destroy');

    // Resignation Management
    Route::get('admin/resignations', [\App\Http\Controllers\ResignationController::class, 'index'])->name('resignations.index');
    Route::post('admin/resignations/data', [\App\Http\Controllers\ResignationController::class, 'data'])->name('resignations.data');
    Route::post('admin/resignations/store', [\App\Http\Controllers\ResignationController::class, 'store'])->name('resignations.store');
    Route::post('admin/resignations/{id}/update-status', [\App\Http\Controllers\ResignationController::class, 'updateStatus'])->name('resignations.update_status');
    Route::get('admin/resignations/notice-period/{employee_id}', [\App\Http\Controllers\ResignationController::class, 'getNoticePeriod'])->name('resignations.notice_period');


    // Recruitment Suite
    Route::prefix('admin/recruitment')->group(function () {
        Route::resource('candidates', \App\Http\Controllers\CandidateController::class);
        Route::resource('jobs', \App\Http\Controllers\JobController::class);
        Route::resource('interviews', \App\Http\Controllers\InterviewController::class);
        Route::resource('requests', \App\Http\Controllers\JobRequestController::class);

        // Custom Action Routes
        Route::post('requests/{id}/approve', [\App\Http\Controllers\JobRequestController::class, 'approve'])->name('requests.approve');
        Route::post('requests/{id}/reject', [\App\Http\Controllers\JobRequestController::class, 'reject'])->name('requests.reject');
        Route::post('candidates/{id}/convert', [\App\Http\Controllers\CandidateController::class, 'convert'])->name('candidates.convert');
    });
});

require __DIR__.'/auth.php';
