<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\WardController;

/*
|--------------------------------------------------------------------------
| WellMeadows HMS — Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('patients', PatientController::class);
    Route::resource('staff', StaffController::class);

    Route::get('/wards', [WardController::class, 'index'])->name('wards.index');
    Route::get('/wards/{ward}', [WardController::class, 'show'])->name('wards.show');
    Route::get('/wards/{ward}/bed/{bed}', [WardController::class, 'showBed'])->name('wards.bed');

    Route::get('/appointments', function () {
        return view('appointments');
    });

    Route::get('/billing', function () {
        return view('billing');
    });

    Route::get('/reports', function () {
        return view('reports');
    });
});
