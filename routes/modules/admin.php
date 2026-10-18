<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    require __DIR__.'/admin/dashboard.php';
    require __DIR__.'/admin/rooms.php';
    require __DIR__.'/admin/schedules.php';
    require __DIR__.'/admin/facilities.php';
    require __DIR__.'/admin/users.php';
    require __DIR__.'/admin/bookings.php';
    require __DIR__.'/admin/reports.php';
});
