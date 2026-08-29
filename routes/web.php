<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeManagerController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OperasionalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Kaligraph Design
|--------------------------------------------------------------------------
*/

// Public Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');

// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    // Portal Choice
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    // Admin & Staff Login
    Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
    Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

    // Customer Login & Register
    Route::get('/login/customer', [AuthController::class, 'showCustomerLogin'])->name('login.customer');
    Route::post('/login/customer', [AuthController::class, 'loginCustomer'])->name('login.customer.post');

    Route::get('/register', [AuthController::class, 'showCustomerRegister'])->name('register');
    Route::get('/register/customer', [AuthController::class, 'showCustomerRegister'])->name('register.customer');
    Route::post('/register/customer', [AuthController::class, 'registerCustomer'])->name('register.customer.post');

    // Forgot Password OTP Flow
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');

    Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.otp.verify');
    Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify.post');
    Route::post('/forgot-password/resend', [ForgotPasswordController::class, 'resendOtp'])->name('password.otp.resend');

    Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/switch-branch', [AuthController::class, 'switchBranch'])->name('switch-branch');

    // Customer Portal
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kasir POS
    Route::prefix('kasir')->name('kasir.')->middleware('permission:kasir')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('index');
        Route::post('/', [KasirController::class, 'store'])->name('store');
        Route::get('/receipt/{order}', [KasirController::class, 'receipt'])->name('receipt');
        Route::get('/history', [KasirController::class, 'history'])->name('history');
    });

    // Produk
    Route::prefix('produk')->name('produk.')->middleware('permission:produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::post('/', [ProdukController::class, 'store'])->name('store');
        Route::put('/{product}', [ProdukController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProdukController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/toggle', [ProdukController::class, 'toggleActive'])->name('toggle');
    });

    // Stok
    Route::prefix('stok')->name('stok.')->middleware('permission:stok')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
        Route::post('/', [StokController::class, 'store'])->name('store');
        Route::delete('/{stock}', [StokController::class, 'destroy'])->name('destroy');
    });

    // Produksi
    Route::prefix('produksi')->name('produksi.')->middleware('permission:produksi')->group(function () {
        Route::get('/', [ProduksiController::class, 'index'])->name('index');
        Route::post('/', [ProduksiController::class, 'store'])->name('store');
        Route::get('/{produksi}', [ProduksiController::class, 'show'])->name('show');
        Route::put('/{produksi}', [ProduksiController::class, 'update'])->name('update');
        Route::delete('/{produksi}', [ProduksiController::class, 'destroy'])->name('destroy');
    });

    // Operasional
    Route::prefix('operasional')->name('operasional.')->middleware('permission:operasional')->group(function () {
        Route::get('/', [OperasionalController::class, 'index'])->name('index');
        Route::post('/', [OperasionalController::class, 'store'])->name('store');
        Route::put('/{operasional}', [OperasionalController::class, 'update'])->name('update');
        Route::delete('/{operasional}', [OperasionalController::class, 'destroy'])->name('destroy');
    });

    // Users Management
    Route::prefix('users')->name('users.')->middleware('permission:users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Permissions Matrix
    Route::prefix('akses')->name('akses.')->middleware('permission:akses')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::put('/{user}', [PermissionController::class, 'update'])->name('update');
    });

    // Branch Store Management (Owner/Superadmin)
    Route::prefix('branches')->name('branches.')->middleware('role:superadmin,owner')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('index');
        Route::post('/', [BranchController::class, 'store'])->name('store');
        Route::put('/{branch}', [BranchController::class, 'update'])->name('update');
        Route::delete('/{branch}', [BranchController::class, 'destroy'])->name('destroy');
    });

    // Landing Page Manager
    Route::prefix('home-manager')->name('home_manager.')->middleware('permission:home_manager')->group(function () {
        Route::get('/', [HomeManagerController::class, 'index'])->name('index');
        Route::post('/', [HomeManagerController::class, 'store'])->name('store');
        Route::put('/{homeContent}', [HomeManagerController::class, 'update'])->name('update');
        Route::delete('/{homeContent}', [HomeManagerController::class, 'destroy'])->name('destroy');
        Route::post('/{homeContent}/toggle', [HomeManagerController::class, 'toggleActive'])->name('toggle');
    });

    // Activity Log
    Route::prefix('activity-log')->name('activity_log.')->middleware('permission:activity_log')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::post('/clear', [ActivityLogController::class, 'clear'])->name('clear');
    });
});
