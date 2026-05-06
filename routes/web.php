<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\HODController;
use App\Http\Controllers\FacultyDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\NlQueryController;
use App\Http\Controllers\MlRiskPredictionController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\FacultyManagementController;

// Home & Auth Routes
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    // Redirect authenticated users to their role-specific dashboard
    $userRole = auth()->user()->role->slug;
    
    return match($userRole) {
        'admin' => redirect()->route('admin.dashboard'),
        'hod' => redirect()->route('hod.dashboard'),
        'faculty' => redirect()->route('faculty.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => redirect()->route('login'),
    };
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Admin Routes
    Route::middleware(['authRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/students', [AdminDashboardController::class, 'students'])->name('students');
        Route::get('/courses', [AdminDashboardController::class, 'courses'])->name('courses');
        Route::get('/alerts', [AdminDashboardController::class, 'alerts'])->name('alerts');

        // Faculty Management
        Route::prefix('faculty')->name('faculty.')->group(function () {
            Route::get('/pending-approvals', [FacultyManagementController::class, 'pendingApprovals'])->name('pending');
            Route::post('/approve/{faculty}', [FacultyManagementController::class, 'approveFaculty'])->name('approve');
            Route::post('/reject/{faculty}', [FacultyManagementController::class, 'rejectFaculty'])->name('reject');
            Route::get('/manage', [FacultyManagementController::class, 'manageFaculty'])->name('manage');
            Route::get('/{faculty}/assign-students', [FacultyManagementController::class, 'assignStudentsForm'])->name('assign-form');
            Route::post('/{faculty}/assign-students', [FacultyManagementController::class, 'assignStudents'])->name('assign');
            Route::post('/{faculty}/remove-student/{student}', [FacultyManagementController::class, 'removeStudent'])->name('remove-student');
            Route::post('/{faculty}/update-max-students', [FacultyManagementController::class, 'updateMaxStudents'])->name('update-max');
            Route::get('/statistics', [FacultyManagementController::class, 'statistics'])->name('statistics');
        });
    });

    // HOD Routes
    Route::middleware(['authRole:hod'])->prefix('hod')->name('hod.')->group(function () {
        Route::get('/dashboard', [HODController::class, 'dashboard'])->name('dashboard');
        
        // Faculty Management
        Route::get('/faculty', [HODController::class, 'manageFaculty'])->name('faculty');
        Route::get('/faculty/{id}', [HODController::class, 'showFaculty'])->name('faculty.show');
        
        // Student Management
        Route::get('/students', [HODController::class, 'manageStudents'])->name('students');
        Route::get('/students/{id}', [HODController::class, 'showStudent'])->name('students.show');
        
        // Course Management
        Route::get('/courses', [HODController::class, 'manageCourses'])->name('courses');
        
        // Analytics
        Route::get('/analytics', [HODController::class, 'analytics'])->name('analytics');
        
        // Student Alerts API
        Route::get('/student/{student}/alerts', [HODController::class, 'getStudentAlerts'])->name('student.alerts');
    });

    // Faculty Routes
    Route::middleware(['authRole:faculty'])->prefix('faculty')->name('faculty.')->group(function () {
        Route::get('/dashboard', [FacultyDashboardController::class, 'index'])->name('dashboard');
        Route::get('/courses', [FacultyDashboardController::class, 'courses'])->name('courses');
        Route::get('/course/{id}', [FacultyDashboardController::class, 'course'])->name('course.show');
        Route::get('/attendance', [FacultyDashboardController::class, 'attendance'])->name('attendance');
        Route::post('/attendance', [FacultyDashboardController::class, 'recordAttendance'])->name('attendance.store');
        Route::put('/attendance/{attendance}', [FacultyDashboardController::class, 'updateAttendance'])->name('attendance.update');
        Route::post('/marks', [FacultyDashboardController::class, 'addMarks'])->name('marks.store');
    });

    // Student Routes
    Route::middleware(['authRole:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/marks', [StudentDashboardController::class, 'marks'])->name('marks');
        Route::get('/attendance', [StudentDashboardController::class, 'attendance'])->name('attendance');
        Route::get('/risk-prediction', [StudentDashboardController::class, 'riskPrediction'])->name('risk');
        Route::get('/alerts', [StudentDashboardController::class, 'alerts'])->name('alerts');
    });

    // NLP Query Routes
    Route::prefix('nlp')->name('nlp.')->group(function () {
        Route::get('/queries', [NlQueryController::class, 'index'])->name('index');
        Route::get('/create', [NlQueryController::class, 'create'])->name('create');
        Route::post('/store', [NlQueryController::class, 'store'])->name('store');
        Route::get('/query/{nlQuery}', [NlQueryController::class, 'show'])->name('show');
    });

    // Email Notification Routes - accessible to Admin, Faculty, and HOD
    Route::middleware(['authRole:admin,faculty,hod'])->group(function () {
        Route::prefix('email')->name('email.')->group(function () {
            Route::get('/send', [EmailController::class, 'showSendForm'])->name('send');
            Route::post('/send', [EmailController::class, 'sendNotification'])->name('send.store');
            Route::get('/history', [EmailController::class, 'showHistory'])->name('history');
            Route::post('/resend/{emailLog}', [EmailController::class, 'resend'])->name('resend');
            Route::get('/stats', [EmailController::class, 'getStats'])->name('stats');
        });
    });

    // ML Risk Prediction Routes
    Route::post('/predict-risk/{student}/{course}', [MlRiskPredictionController::class, 'predictRisk'])->name('predict-risk');
});
