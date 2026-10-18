<?php

use App\Http\Controllers\Admin\RoomScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('schedules', [RoomScheduleController::class, 'index'])->name('schedules.index');
Route::post('schedules', [RoomScheduleController::class, 'store'])->name('schedules.store');
Route::put('schedules/{schedule}', [RoomScheduleController::class, 'update'])->name('schedules.update');
Route::delete('schedules/{schedule}', [RoomScheduleController::class, 'destroy'])->name('schedules.destroy');
