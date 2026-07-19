<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'active'])->get('/dashboard', function () {
    return redirect()->route(Auth::user()->isAdmin() ? 'admin.dashboard' : 'student.dashboard');
})->name('dashboard');

Route::middleware(['auth', 'active', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/equipment', [StudentController::class, 'equipment'])->name('equipment');
    Route::get('/equipment/{equipment}', [StudentController::class, 'equipmentShow'])->name('equipment.show');
    Route::get('/bookings', [StudentController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/create', [StudentController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [StudentController::class, 'storeBooking'])->name('bookings.store');
    Route::patch('/bookings/{booking}/cancel', [StudentController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/return-request', [StudentController::class, 'requestReturn'])->name('bookings.return_request');
    Route::get('/fines', [StudentController::class, 'fines'])->name('fines');
    Route::get('/damage-reports', [StudentController::class, 'damageReports'])->name('damage_reports');
    Route::post('/damage-reports', [StudentController::class, 'storeDamageReport'])->name('damage_reports.store');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
});

Route::middleware(['auth', 'active', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/equipment', [AdminController::class, 'equipment'])->name('equipment');
    Route::get('/equipment/create', [AdminController::class, 'createEquipment'])->name('equipment.create');
    Route::post('/equipment', [AdminController::class, 'storeEquipment'])->name('equipment.store');
    Route::get('/equipment/{equipment}/edit', [AdminController::class, 'editEquipment'])->name('equipment.edit');
    Route::put('/equipment/{equipment}', [AdminController::class, 'updateEquipment'])->name('equipment.update');
    Route::delete('/equipment/{equipment}', [AdminController::class, 'deleteEquipment'])->name('equipment.delete');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
    Route::get('/issued', [AdminController::class, 'issued'])->name('issued');
    Route::get('/overdue', [AdminController::class, 'overdue'])->name('overdue');
    Route::patch('/bookings/{booking}/approve', [AdminController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [AdminController::class, 'rejectBooking'])->name('bookings.reject');
    Route::patch('/bookings/{booking}/issue', [AdminController::class, 'issueBooking'])->name('bookings.issue');
    Route::patch('/bookings/{booking}/return', [AdminController::class, 'returnBooking'])->name('bookings.return');

    Route::get('/fines', [AdminController::class, 'fines'])->name('fines');
    Route::patch('/fines/{fine}/toggle', [AdminController::class, 'toggleFine'])->name('fines.toggle');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
    Route::get('/damage-reports', [AdminController::class, 'damageReports'])->name('damage_reports');
    Route::patch('/damage-reports/{damageReport}', [AdminController::class, 'updateDamageReport'])->name('damage_reports.update');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});
