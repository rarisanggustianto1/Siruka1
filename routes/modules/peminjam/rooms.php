<?php

use App\Http\Controllers\Peminjam\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/schedule', [RoomController::class, 'scheduleJson'])->name('rooms.schedule-json');
