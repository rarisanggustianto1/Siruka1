<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('peminjam.dashboard');
    })->name('dashboard');

    Route::get('/user', function () {
        return redirect()->route('peminjam.dashboard');
    });
});
