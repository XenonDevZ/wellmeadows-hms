<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\WardController;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ReportController;

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
    Route::resource('appointments', AppointmentController::class);

    Route::get('/wards', [WardController::class, 'index'])->name('wards.index');
    Route::get('/wards/{ward}', [WardController::class, 'show'])->name('wards.show');
    Route::get('/wards/{ward}/bed/{bed}', [WardController::class, 'showBed'])->name('wards.bed');

    // Billing & Requisition Dashboard
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    
    // Patient Billing Actions
    Route::get('/billing/create', [BillingController::class, 'createBill'])->name('billing.create');
    Route::post('/billing', [BillingController::class, 'storeBill'])->name('billing.store');
    Route::post('/billing/{bill}/pay', [BillingController::class, 'payBill'])->name('billing.pay');

    // Ward Requisition Actions
    Route::get('/requisitions/create', [BillingController::class, 'createRequisition'])->name('requisitions.create');
    Route::post('/requisitions', [BillingController::class, 'storeRequisition'])->name('requisitions.store');
    Route::post('/requisitions/{req}/approve', [BillingController::class, 'approveRequisition'])->name('requisitions.approve');

    // Stock Item Actions
    Route::post('/items', [BillingController::class, 'storeItem'])->name('items.store');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/ward-allocation', [ReportController::class, 'wardAllocation'])->name('reports.ward_allocation');
    Route::get('/reports/billing', [ReportController::class, 'billing'])->name('reports.billing');
    Route::get('/reports/appointments', [ReportController::class, 'appointments'])->name('reports.appointments');
    Route::get('/reports/requisitions', [ReportController::class, 'requisitions'])->name('reports.requisitions');
    Route::get('/reports/medications', [ReportController::class, 'medications'])->name('reports.medications');
});
