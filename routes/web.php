<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ReportController;

// Redirect root to login
Route::redirect('/', 'login');

// Authentication Routes
Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        // Staff Management
        Route::resource('staff', StaffController::class);
        
        // Project Management
        Route::resource('projects', ProjectController::class);
        Route::post('/projects/{project}/assign', [ProjectController::class, 'assignStaff'])->name('projects.assign');
        
        // Task Management (Admin only - create and store)
        Route::resource('tasks', TaskController::class)->only(['create', 'store']);
        
        // Attendance Management (Admin)
        Route::resource('attendances', AttendanceController::class);
        
        // Asset Management
        Route::resource('assets', AssetController::class);
        Route::post('/assets/{asset}/assign', [AssetController::class, 'assign'])->name('assets.assign');
        Route::post('/assets/{asset}/unassign', [AssetController::class, 'unassign'])->name('assets.unassign');
        
        // Notice Management (Admin full CRUD)
        Route::resource('notices', NoticeController::class);
        Route::post('/notices/{notice}/toggle-status', [NoticeController::class, 'toggleStatus'])->name('notices.toggle-status');
        
        // Reports (Admin Only)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
            Route::get('/attendance', [ReportController::class, 'attendanceReport'])->name('attendance');
            Route::get('/leaves', [ReportController::class, 'leaveReport'])->name('leaves');
            Route::get('/projects', [ReportController::class, 'projectReport'])->name('projects');
            Route::get('/staff', [ReportController::class, 'staffReport'])->name('staff');
            Route::get('/tasks', [ReportController::class, 'taskReport'])->name('tasks');
        });
        
        // Leave Approval (Admin only)
        Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    });
    
    // Staff Routes
    Route::middleware(['role:staff'])->group(function () {
        // Time Logs
        Route::post('/time-logs/start', [TimeLogController::class, 'start'])->name('time-logs.start');
        Route::post('/time-logs/end', [TimeLogController::class, 'end'])->name('time-logs.end');
        
        // Attendance Check-in/Check-out
        Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    });
    
    // Common Routes (accessible by both admin and staff)
    
    // Task Management (Both can view, edit, update, show - but only admin creates)
    Route::resource('tasks', TaskController::class)->except(['create', 'store', 'destroy']);
    
    // Time Logs View
    Route::get('/time-logs', [TimeLogController::class, 'index'])->name('time-logs.index');
    
    // Leave Management (Both can view and apply, but only staff can create)
    Route::resource('leaves', LeaveController::class)->except(['destroy']);
    
    // Notices (View only for both, but admin has full CRUD through admin routes)
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::get('/notices/{notice}', [NoticeController::class, 'show'])->name('notices.show');
    
    // Attendance (View only for both, but admin has full CRUD through admin routes)
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    
    // Profile Management
    Route::get('/my-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/my-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});

