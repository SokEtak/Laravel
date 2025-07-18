<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ScheduleController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

//authenticated
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('schedules', ScheduleController::class);
});

//unauthenticated
Route::get('/grades', function (Request $request) {
    $program = $request->query('program');

    return Inertia::render('E-Books/Grade', [
        'program' => $program,
    ]);
})->name('grade');

Route::get('/subjects', function (Request $request) {
    $program = $request->query('program');
    $grade = $request->query('grade');
    $subject = $request->query('subject');

    return Inertia::render('E-Books/Subject', [
        'program' => $program,
        'grade' => $grade,
        'subject' => $subject,
    ]);
})->name('subject');

Route::get('/lessons', function (Request $request) {
    $program = $request->query('program');
    $grade = $request->query('grade');
    $subject = $request->query('subject');
    return Inertia::render('E-Books/Lesson', [
        'subject' => $subject,
        'program' => $program,
        'grade' => $grade,
    ]);
})->name('lesson');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
