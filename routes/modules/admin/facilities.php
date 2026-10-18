<?php

use App\Http\Controllers\Admin\FacilityController;
use Illuminate\Support\Facades\Route;

Route::resource('facilities', FacilityController::class)->except(['create', 'show']);
Route::post('facilities/inventory', [FacilityController::class, 'inventory'])->name('facilities.inventory');
Route::delete('facilities/inventory/{room}/{facility}', [FacilityController::class, 'destroyInventory'])->name('facilities.inventory.destroy');
