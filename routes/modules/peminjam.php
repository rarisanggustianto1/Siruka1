<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'peminjam'])->prefix('peminjam')->name('peminjam.')->group(function (): void {
    require __DIR__.'/peminjam/dashboard.php';
    require __DIR__.'/peminjam/rooms.php';
    require __DIR__.'/peminjam/bookings.php';
    require __DIR__.'/peminjam/profile.php';
});
