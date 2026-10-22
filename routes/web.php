<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Sesuaikan dengan controller auth Anda
use App\Http\Controllers\AuthController; // Sesuaikan namespace AuthController Anda

// 1. Tambahkan route root '/' agar saat logout tidak error 404
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Route untuk Logout (menggunakan method POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Atau jika menggunakan controller login langsung:
// Route::get('/', [LoginController::class, 'showLoginForm']);

// Pastikan ada ->name('login') di ujung route ini:
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Tambahkan di dalam grup middleware auth:
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

});

Route::middleware(['auth'])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // 2. Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // 3. Students
    Route::resource('students', StudentController::class);
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    
    //4. Classes
    Route::middleware(['auth'])->group(function () {
    Route::resource('classes', SchoolClassController::class);
    });
    // 5. Subjects
    // Route Subjects (Dapat diakses user terotentikasi)
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    
    // Route khusus aksi modifikasi/tambah/edit/hapus Subject
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    // 6. Teachers (Bisa diakses semua user terotentikasi)
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');

    // Akses Khusus Admin (Aksi Modifikasi Data Guru)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
        Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
        Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
        Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
        Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    });

    // Logout Route (Mendukung GET dan POST)
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

}); // Penutup Route::middleware(['auth'])