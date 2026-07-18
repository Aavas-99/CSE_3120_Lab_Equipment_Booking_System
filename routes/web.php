<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::patch('/bookings/{booking}/approve', [AdminController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [AdminController::class, 'rejectBooking'])->name('bookings.reject');
    Route::patch('/bookings/{booking}/issue', [AdminController::class, 'issueBooking'])->name('bookings.issue');
    Route::patch('/bookings/{booking}/return', [AdminController::class, 'returnBooking'])->name('bookings.return');
});

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/fines', [StudentController::class, 'fines'])->name('fines');
});

require __DIR__.'/auth.php';
