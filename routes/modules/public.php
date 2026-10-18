<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Peminjam\RoomController as PublicRoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms/{room}', [PublicRoomController::class, 'show'])->name('public.rooms.show');
