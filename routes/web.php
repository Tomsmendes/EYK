<?php

use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

/*
// Grupo de rotas para estudantes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/videos', [StudentController::class, 'indexVideos'])->name('student.videos.index');
    Route::get('/student/courses', [StudentController::class, 'indexCourses'])->name('student.courses.index');
});

// Grupo de rotas para professores
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/videos', [TeacherController::class, 'indexVideos'])->name('teacher.videos.index');
    Route::get('/teacher/videos/create', [TeacherController::class, 'createVideo'])->name('teacher.videos.create');
    Route::post('/teacher/videos', [TeacherController::class, 'storeVideo'])->name('teacher.videos.store');

    Route::get('/teacher/courses', [TeacherController::class, 'indexCourses'])->name('teacher.courses.index');
    Route::get('/teacher/courses/create', [TeacherController::class, 'createCourse'])->name('teacher.courses.create');
    Route::post('/teacher/courses', [TeacherController::class, 'storeCourse'])->name('teacher.courses.store');
});
*/



Route::get('/student/videos', [StudentController::class, 'indexVideos'])->name('student.videos.index');
Route::get('/student/courses', [StudentController::class, 'indexCourses'])->name('student.courses.index');




Route::get('/teacher/videos', [TeacherController::class, 'indexVideos'])->name('teacher.videos.index');
Route::get('/teacher/videos/create', [TeacherController::class, 'createVideo'])->name('teacher.videos.create');
Route::post('/teacher/videos', [TeacherController::class, 'storeVideo'])->name('teacher.videos.store');

Route::get('/teacher/courses', [TeacherController::class, 'indexCourses'])->name('teacher.courses.index');
Route::get('/teacher/courses/create', [TeacherController::class, 'createCourse'])->name('teacher.courses.create');
Route::post('/teacher/courses', [TeacherController::class, 'storeCourse'])->name('teacher.courses.store');





// Rotas de usuário (admin)
Route::get('admin/users', [UserController::class, 'index'])->name('admin.student.user.index');


Route::get('admin/teacher/users', [UserController::class, 'indexp'])->name('admin.teacher.user.index');

// Rotas de registro
Route::get('register', [UserController::class, 'indexRegister'])->name('register');
Route::post('register', [UserController::class, 'register'])->name('register.post');

// Rotas de login
Route::get('login', [UserController::class, 'indexLogin'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login.post');


Route::post('/logout', [UserController::class, 'logout'])->name('logout');

