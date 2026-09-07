<?php

use App\Http\Controllers\DataSampelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Section 5, User Roles & Access Control:
// - Lab Head (Admin): full sample CRUD + full statistics dashboard.
// - Analyst (Staff): view list & dashboard; update only analysis status
//   and testing notes. Create and delete are blocked by `role` middleware.
Route::get('/dashboard', [DataSampelController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('data-sampels', [DataSampelController::class, 'index'])
        ->name('data-sampels.index');

    Route::middleware('role:admin')->group(function () {
        Route::post('data-sampels', [DataSampelController::class, 'store'])
            ->name('data-sampels.store');
        Route::delete('data-sampels/{dataSampel}', [DataSampelController::class, 'destroy'])
            ->name('data-sampels.destroy');
    });

    // Both roles may hit update, but the controller restricts Staff to
    // status_uji + catatan_kondisi only (see DataSampelController@update).
    Route::put('data-sampels/{dataSampel}', [DataSampelController::class, 'update'])
        ->name('data-sampels.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
