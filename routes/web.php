<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;

// Public Routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Venue Routes (Public)
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');
// Allow viewing booking page without login; actual booking POST remains protected
Route::get('/venues/{venue}/booking', [BookingController::class, 'create'])->name('venues.booking');

// Slot Routes (Public)
Route::get('/slots', [SlotController::class, 'index'])->name('slots.index');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Booking
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/return', [BookingController::class, 'submitReturn'])->name('bookings.return');
    
    // Join Slot
    Route::post('/slots/{slot}/join', [SlotController::class, 'join'])->name('slots.join');
});

// Admin Routes (protected - wajib login)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/fields', [AdminFieldController::class, 'index'])->name('fields.index');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/confirm-return', [AdminBookingController::class, 'confirmReturn'])->name('bookings.confirmReturn');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
});
