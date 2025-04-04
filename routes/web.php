<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OfferLetterController;
use App\Http\Controllers\CompanySwitchController;

// ✅ Public Route
Route::get('/', function () {
    return view('welcome');
});

// ✅ Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update-password')->middleware('auth');

// ✅ Authenticated Routes (Require Login + Company Selected)
Route::middleware(['auth', 'company'])->group(function () {

    // ✅ Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Switch Company
    Route::post('/switch-company', [CompanySwitchController::class, 'switch'])->name('switch.company');

    // ✅ Dashboard
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');

    // ✅ Role-Based Dashboards
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware('role:Company Admin')->group(function () {
        Route::get('/company-dashboard', [AdminController::class, 'companyDashboard'])->name('company.dashboard');
    });

    Route::middleware('role:HR Admin')->group(function () {
        Route::get('/hr-dashboard', [AdminController::class, 'hrDashboard'])->name('hr.dashboard');
    });

    // ✅ Companies
    Route::resource('companies', CompanyController::class)->except(['show']);
    Route::post('/companies/bulk-delete', [CompanyController::class, 'bulkDelete'])->name('companies.bulkDelete');
    Route::post('/companies/{id}/status', [CompanyController::class, 'updateStatus'])->name('companies.status');

    // ✅ Company Users
    Route::prefix('company-users')->group(function () {
        Route::get('/', [CompanyUserController::class, 'index'])->name('company.users.index');
        Route::get('/create', [CompanyUserController::class, 'create'])->name('company.users.create');
        Route::post('/store', [CompanyUserController::class, 'store'])->name('company.users.store');
    });

    // ✅ Employees
    Route::resource('employees', EmployeeController::class)->except(['show']);
    Route::post('/employees/delete-multiple', [EmployeeController::class, 'deleteMultiple'])->name('employees.deleteMultiple');
    Route::post('/employees/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
    Route::post('/employees/bulk-delete', [EmployeeController::class, 'bulkDelete'])->name('employees.bulkDelete');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/employee/{id}/documents', [EmployeeController::class, 'showDocuments']);

    // ✅ Employee Letter Generation
    Route::get('/employees/{id}/generate-letter/{letterType}', 
        [EmployeeController::class, 'generateEmployeeLetter']
    )->name('employees.generateEmployeeLetter');

    // ✅ Employee Public View & Salary PDF (now protected)
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::post('/employees/{id}/generate-salary-pdf', [EmployeeController::class, 'generateSalaryPdf'])->name('employees.generateSalaryPdf');

    // ✅ Document Routes
    Route::resource('documents', DocumentController::class);
    Route::get('documents/generate/{employee_id}/{template_type}', [DocumentController::class, 'generatePDF'])->name('documents.generate');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // ✅ Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    // ✅ Comments
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');

    // ✅ Templates
    Route::resource('templates', TemplateController::class);
    Route::get('/templates/{employeeId}/{templateId}', [TemplateController::class, 'generateLetter'])->name('generate.letter');
    Route::get('/templates/download/{employeeId}/{templateId}', [TemplateController::class, 'downloadPDF'])->name('download.pdf');

    // ✅ Letter Preview
    Route::get('/preview/{id}', [LetterController::class, 'preview'])->name('letter.preview');

    // ✅ Offer Letters
    Route::prefix('employees/{id}')->group(function () {
        Route::get('/offer-letter', [OfferLetterController::class, 'showOfferLetter'])->name('employees.offerLetter');
        Route::get('/download-offer-letter', [OfferLetterController::class, 'downloadOfferLetter'])->name('employees.downloadOfferLetter');
        Route::post('/test', [OfferLetterController::class, 'generateOfferLetter'])->name('employees.test');
    });

    // ✅ Test Route (Optional - For Debugging)
    Route::get('/test-employee/{id}', function ($id) {
        $employee = Employee::with('documents.creator')->find($id);

        if (!$employee) {
            return "Employee not found.";
        }

        foreach ($employee->documents as $document) {
            echo "Title: " . $document->document_title . "<br>";
            echo "PDF: <a href='" . asset($document->pdf_path) . "'>" . $document->pdf_name . "</a><br>";
            echo "Created By: " . ($document->creator->name ?? 'Unknown') . "<br><br>";
        }
    });

});

// ✅ Load Auth Routes (Breeze/Jetstream/etc.)
require __DIR__ . '/auth.php';
