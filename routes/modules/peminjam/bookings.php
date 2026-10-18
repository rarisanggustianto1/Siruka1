<?php

use App\Http\Controllers\Peminjam\BookingController;
use Illuminate\Support\Facades\Route;

Route::resource('bookings', BookingController::class);
Route::get('/bookings/{booking}/cetak', [BookingController::class, 'cetak'])->name('bookings.cetak');
