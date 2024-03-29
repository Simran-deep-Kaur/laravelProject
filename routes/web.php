<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthUser;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::get('/employees/create', function () {
        return view('create');
    });
    Route::post('/employees/create', [EmployeeController::class, 'store'])->name('employee.store');
    Route::middleware(AuthUser::class)->group(function () {
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::delete('/employees/{employee}/delete', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::put('/employees/{employee}/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::get('/employees/{employee}/show', [EmployeeController::class, 'show'])->name('employee.show');
    });
});

Route::post('/employees/check-email', [EmployeeController::class, 'checkEmail'])->name('employee.checkEmail');

Route::get('/admins', [EmployeeController::class, 'admins'])->name('admins');
require __DIR__ . '/auth.php';