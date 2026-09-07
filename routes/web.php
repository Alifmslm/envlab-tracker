<?php

use App\Http\Controllers\DataSampelController;
use Illuminate\Support\Facades\Route;

// Prototype routes. No auth / middleware yet. Breeze will be added later.
Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', fn () => view('auth.login'))->name('login');

Route::get('/dashboard', [DataSampelController::class, 'dashboard'])->name('dashboard');

Route::resource('data-sampels', DataSampelController::class)
    ->parameters(['data-sampels' => 'dataSampel'])
    ->except(['create', 'edit', 'show']);
