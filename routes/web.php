<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AppointmentLookupController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Client Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Appointment Lookup Routes
Route::get('/tra-cuu-lich-hen', [AppointmentLookupController::class, 'index'])->name('appointment.lookup');
Route::post('/tra-cuu-lich-hen', [AppointmentLookupController::class, 'search'])->name('appointment.search');
Route::delete('/huy-lich-hen/{id}', [AppointmentLookupController::class, 'cancel'])->name('appointment.cancel');

// Booking Routes - Yêu cầu đăng nhập
Route::middleware('auth')->prefix('booking')->name('booking.')->group(function () {
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/store', [BookingController::class, 'store'])->name('store');
    Route::get('/success/{id}', [BookingController::class, 'success'])->name('success');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    
    // Specialties Routes
    Route::resource('specialties', \App\Http\Controllers\Admin\SpecialtyController::class);
    
    // Doctors Routes
    Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);
    
    // Appointments Routes
    Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class);
    
    // Doctor Schedules Routes
    Route::resource('schedules', \App\Http\Controllers\Admin\DoctorScheduleController::class);
    
    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

