<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\AdminController;

// Authentication Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware(['auth.session'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Video Call Routes
    Route::get('/video-calls', [VideoCallController::class, 'index'])->name('video-calls.index');
    Route::get('/video-calls/create', [VideoCallController::class, 'create'])->name('video-calls.create');
    Route::post('/video-calls', [VideoCallController::class, 'store'])->name('video-calls.store');
    Route::get('/video-calls/{videoCall}/join', [VideoCallController::class, 'join'])->name('video-calls.join');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/vendors', [AdminController::class, 'vendors'])->name('vendors');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/video-calls', [AdminController::class, 'videoCalls'])->name('video-calls');
    Route::get('/call-logs', [AdminController::class, 'callLogs'])->name('call-logs');
    Route::get('/vendors/{vendor}', [AdminController::class, 'vendorDetails'])->name('vendor-details');
    Route::get('/customers/{customer}', [AdminController::class, 'customerDetails'])->name('customer-details');
});
