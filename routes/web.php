<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    
    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
        Route::get('/sections', [AdminController::class, 'sections'])->name('sections');
        Route::post('/sections', [AdminController::class, 'storeSection'])->name('sections.store');
        Route::get('/classrooms', [AdminController::class, 'classrooms'])->name('classrooms');
        Route::post('/classrooms', [AdminController::class, 'storeClassroom'])->name('classrooms.store');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });

    // Faculty Routes
    Route::middleware('role:faculty')->prefix('faculty')->name('faculty.')->group(function () {
        Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('dashboard');
        Route::get('/section/{id}', [FacultyController::class, 'section'])->name('section');
        Route::post('/approve-student/{enrollment}', [FacultyController::class, 'approveStudent'])->name('approve.student');
        Route::post('/reject-student/{enrollment}', [FacultyController::class, 'rejectStudent'])->name('reject.student');
        Route::post('/grade-student/{grade}', [FacultyController::class, 'gradeStudent'])->name('grade.student');
    });

    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
        Route::post('/request-course', [StudentController::class, 'requestCourse'])->name('request.course');
        Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
        Route::get('/classrooms', [StudentController::class, 'classrooms'])->name('classrooms');
    });
});