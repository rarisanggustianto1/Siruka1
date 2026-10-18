<?php

use App\Http\Controllers\Admin\RoomController;
use Illuminate\Support\Facades\Route;

Route::resource('rooms', RoomController::class);
Route::match(['patch', 'post'], 'rooms/{room}/toggle-status', [RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');
Route::match(['patch', 'post'], 'rooms/{room}/toggle_status', [RoomController::class, 'toggleStatus'])->name('rooms.toggle_status');
