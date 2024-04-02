<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthSuperAdmin;
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
        return view('employees.create');
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
Route::post('/admins/check-email', [AdminController::class, 'checkEmail'])->name('admins.checkEmail');
Route::get('/admins/create', function () {
    return view('admins.create');
});
Route::middleware(AuthSuperAdmin::class)->group(function () {
    Route::get('/admins', [AdminController::class, 'index'])->name('admins');
    Route::get('/admins/{user}/show', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/admins/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::delete('/admins/{user}/delete', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::put('/admins/{user}/update', [AdminController::class, 'update'])->name('admin.update');
});
Route::post('/admins/create', [AdminController::class, 'store'])->name('admin.store');



