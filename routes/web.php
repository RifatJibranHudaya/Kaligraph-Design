<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeManagerController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusOrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Kafa Advertising
|--------------------------------------------------------------------------
*/

// Public Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');

// Public Catalog Pages
Route::get('/katalog', [LandingController::class, 'categories'])->name('katalog');
Route::get('/katalog/{slug}', [LandingController::class, 'productsByCategory'])->name('katalog.kategori');
Route::get('/katalog/{slug}/{product}', [LandingController::class, 'productDetail'])->name('katalog.detail');

// Public Portfolio Page
Route::get('/portofolio', [LandingController::class, 'portfolio'])->name('portofolio');

// Midtrans Payment Notification Webhook (CSRF exempt)
Route::match(['get', 'post'], '/midtrans/webhook', [MidtransController::class, 'webhook'])->name('midtrans.webhook');


// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    // Portal Choice
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    // Admin & Staff Login (Rate limited: 5/min)
    Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
    Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post')
        ->middleware('throttle:login');

    // Customer Login & Register (Rate limited)
    Route::get('/login/customer', [AuthController::class, 'showCustomerLogin'])->name('login.customer');
    Route::post('/login/customer', [AuthController::class, 'loginCustomer'])->name('login.customer.post')
        ->middleware('throttle:login');

    Route::get('/register', [AuthController::class, 'showCustomerRegister'])->name('register');
    Route::get('/register/customer', [AuthController::class, 'showCustomerRegister'])->name('register.customer');
    Route::post('/register/customer', [AuthController::class, 'registerCustomer'])->name('register.customer.post')
        ->middleware('throttle:register');

    // Forgot Password OTP Flow (Rate limited: 3/min)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email')
        ->middleware('throttle:otp');

    Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.otp.verify');
    Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify.post')
        ->middleware('throttle:otp');
    Route::post('/forgot-password/resend', [ForgotPasswordController::class, 'resendOtp'])->name('password.otp.resend')
        ->middleware('throttle:otp');

    Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.update');
});

// Authenticated Routes - Admin/Staff (web guard)
Route::middleware(['auth:web', 'prevent.back'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/switch-branch', [AuthController::class, 'switchBranch'])->name('switch-branch');

    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Produk
    Route::prefix('produk')->name('produk.')->middleware('permission:produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::post('/', [ProdukController::class, 'store'])->name('store')->middleware('throttle:upload');
        Route::put('/{product}', [ProdukController::class, 'update'])->name('update')->middleware('throttle:upload');
        Route::delete('/{product}', [ProdukController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/toggle', [ProdukController::class, 'toggleActive'])->name('toggle');
        Route::post('/{product}/adjust-stock', [ProdukController::class, 'adjustStock'])->name('adjust_stock');
    });

    // Kategori Produk
    Route::prefix('kategori')->name('kategori.')->middleware('permission:kategori')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store')->middleware('throttle:upload');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update')->middleware('throttle:upload');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::post('/{category}/toggle', [CategoryController::class, 'toggleActive'])->name('toggle');
    });

    // Portofolio
    Route::prefix('portfolio')->name('portfolio.')->middleware('permission:portfolio')->group(function () {
        Route::get('/', [PortfolioController::class, 'index'])->name('index');
        Route::post('/', [PortfolioController::class, 'store'])->name('store')->middleware('throttle:upload');
        Route::put('/{portfolio}', [PortfolioController::class, 'update'])->name('update')->middleware('throttle:upload');
        Route::delete('/{portfolio}', [PortfolioController::class, 'destroy'])->name('destroy');
        Route::post('/{portfolio}/toggle', [PortfolioController::class, 'toggleActive'])->name('toggle');
    });

    // Data Pembayaran (Satu Pintu dengan Status Pengerjaan)
    Route::prefix('pembayaran')->name('pembayaran.')->middleware('permission:status_order')->group(function () {
        Route::get('/', fn() => redirect()->route('status_order.index'))->name('index');
        Route::post('/', [PaymentController::class, 'store'])->name('store')->middleware('throttle:checkout');
        Route::get('/{payment}/nota', [PaymentController::class, 'nota'])->name('nota');
        Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('destroy');
        Route::get('/order/{order}/detail', [PaymentController::class, 'detailOrder'])->name('detail.order');
        Route::get('/order/{order}/snap-token', [MidtransController::class, 'getSnapToken'])->name('order.snap.token');
        Route::post('/order/{order}/send-whatsapp', [PaymentController::class, 'sendWhatsapp'])->name('send.whatsapp');
        Route::post('/order/{order}/verify-receipt', [PaymentController::class, 'verifyReceipt'])->name('verify.receipt');
        Route::post('/order/{order}/reject-receipt', [PaymentController::class, 'rejectReceipt'])->name('reject.receipt');
    });

    // Status Pengerjaan Order
    Route::prefix('status-order')->name('status_order.')->middleware('permission:status_order')->group(function () {
        Route::get('/', [StatusOrderController::class, 'index'])->name('index');
        Route::post('/', [StatusOrderController::class, 'store'])->name('store')->middleware('throttle:checkout');
        Route::get('/search-pelanggan', [StatusOrderController::class, 'searchPelanggan'])->name('search_pelanggan');
        Route::put('/{order}/status', [StatusOrderController::class, 'updateStatus'])->name('update_status');
    });

    // Users Management (Staf & Internal)
    Route::prefix('users')->name('users.')->middleware('permission:users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Pelanggan Management (Khusus Akun Customer)
    Route::prefix('pelanggan')->name('pelanggan.')->middleware('permission:users')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('index');
        Route::post('/', [PelangganController::class, 'store'])->name('store');
        Route::put('/{pelanggan}', [PelangganController::class, 'update'])->name('update');
        Route::delete('/{pelanggan}', [PelangganController::class, 'destroy'])->name('destroy');
        Route::get('/{pelanggan}/orders', [PelangganController::class, 'orders'])->name('orders');
    });

    // Permissions Matrix
    Route::prefix('akses')->name('akses.')->middleware('permission:akses')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/pelanggan', [PermissionController::class, 'pelanggan'])->name('pelanggan');
        Route::put('/pelanggan', [PermissionController::class, 'updatePelangganLevel'])->name('pelanggan.update');
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
        Route::get('/export-csv', [ActivityLogController::class, 'exportCsv'])->name('export_csv');
        Route::post('/archive', [ActivityLogController::class, 'archive'])->name('archive');
        Route::get('/download-archive/{filename}', [ActivityLogController::class, 'downloadArchive'])->name('download_archive')->where('filename', '.+');
    });

    // WhatsApp Contact Settings
    Route::prefix('settings')->name('settings.')->middleware('role:superadmin,owner,admin')->group(function () {
        Route::get('/whatsapp', [SettingController::class, 'whatsapp'])->name('whatsapp');
        Route::post('/whatsapp', [SettingController::class, 'updateWhatsapp'])->name('whatsapp.update');
    });
});

// Customer Portal Routes (customer guard)
Route::middleware(['auth:customer', 'prevent.back'])->group(function () {
    Route::post('/customer/logout', [AuthController::class, 'customerLogout'])->name('customer.logout');
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::post('/customer/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    
    // Detail pembayaran manual (upload bukti) untuk pelanggan
    Route::get('/customer/order/{order}/detail', [PaymentController::class, 'detailOrder'])->name('customer.order.detail');
    Route::get('/customer/order/{order}/snap-token', [MidtransController::class, 'getSnapToken'])->name('customer.order.snap.token');
    Route::post('/customer/order/{order}/payment-upload', [PaymentController::class, 'customerUploadReceipt'])->name('customer.payment.upload')
        ->middleware('throttle:upload');
    // Halaman Khusus Pembayaran Online Midtrans (E-Commerce Products Only)
    Route::get('/customer/order/{order}/midtrans', [MidtransController::class, 'showPaymentPage'])->name('customer.order.midtrans');
    Route::post('/customer/order/{order}/midtrans-success', [MidtransController::class, 'paymentSuccessCallback'])->name('customer.order.midtrans.success');
    Route::post('/customer/order/{order}/cancel', [CustomerController::class, 'cancelOrder'])->name('customer.order.cancel');
    // Existing routes
    Route::post('/customer/order/{order}/send-whatsapp', [PaymentController::class, 'sendWhatsapp'])->name('customer.order.send.whatsapp');

    // Cart Routes
    Route::prefix('customer/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'addItem'])->name('add');
        Route::put('/item/{cartItem}', [CartController::class, 'updateItem'])->name('update');
        Route::delete('/item/{cartItem}', [CartController::class, 'removeItem'])->name('remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout')
            ->middleware('throttle:checkout');
    });
});

// Instant Direct Checkout via Midtrans (E-Commerce Products)
Route::post('/customer/instant-buy/{product}', [CartController::class, 'instantBuy'])->name('customer.instant.buy');
