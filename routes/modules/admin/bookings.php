<?php

use App\Http\Controllers\Admin\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::get('bookings/{booking}/cetak', [BookingController::class, 'cetak'])->name('bookings.cetak');
Route::match(['patch', 'post'], 'bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
Route::get('bookings/{booking}/reject', [BookingController::class, 'showRejectForm'])->name('bookings.reject_form');
Route::get('bookings/{booking}/reject-form', [BookingController::class, 'showRejectForm'])->name('bookings.reject-form');
Route::match(['patch', 'post'], 'bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
