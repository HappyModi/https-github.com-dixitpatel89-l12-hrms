<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AttendanceController;

// ✅ Public Route
Route::get('/', function () {
    return view('welcome');
});

// ✅ Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ✅ Authenticated Routes (Require Login)
Route::middleware(['auth'])->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Dashboard Route (Uses EmployeeController)
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');

    // ✅ Role-Based Routes (Using Spatie Role Middleware)
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware('role:Company Admin')->group(function () {
        Route::get('/company-dashboard', [AdminController::class, 'companyDashboard'])->name('company.dashboard');
    });

    Route::middleware('role:HR Admin')->group(function () {
        Route::get('/hr-dashboard', [AdminController::class, 'hrDashboard'])->name('hr.dashboard');
    });

    // ✅ Company Routes (CRUD)
    Route::resource('companies', CompanyController::class)->except(['show']);

    // Company Bulk Delete
    Route::post('/companies/bulk-delete', [CompanyController::class, 'bulkDelete'])->name('companies.bulkDelete');

    // ✅ Company Switching Route
    Route::post('/switch-company', [CompanyController::class, 'switchCompany'])->name('switch.company');

    // ✅ Company User Management
    Route::prefix('company-users')->group(function () {
        Route::get('/', [CompanyUserController::class, 'index'])->name('company.users.index');
        Route::get('/create', [CompanyUserController::class, 'create'])->name('company.users.create');
        Route::post('/store', [CompanyUserController::class, 'store'])->name('company.users.store');
    });

    // ✅ Employee Routes (CRUD)
    Route::resource('employees', EmployeeController::class)->except(['show']);
    Route::post('/employees/delete-multiple', [EmployeeController::class, 'deleteMultiple'])->name('employees.deleteMultiple');
    Route::post('/employees/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggleStatus');
    Route::post('/employees/{id}/status', [EmployeeController::class, 'changeStatus']);
});
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
Route::post('/employees/{id}/generate-salary-pdf', [EmployeeController::class, 'generateSalaryPdf'])
    ->name('employees.generateSalaryPdf');
    Route::resource('attendance', AttendanceController::class);
    Route::get('/attendance/previous/{id}', [AttendanceController::class, 'getPreviousMonthData']);

    Route::get('/attendance/getEmployees', [AttendanceController::class, 'getEmployees'])
    ->name('attendance.getEmployees');

    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');


// ✅ Load Additional Authentication Routes
require __DIR__ . '/auth.php';
