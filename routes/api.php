<?php

use App\Http\Controllers\Api\SampleController;
use Illuminate\Support\Facades\Route;

Route::get('/samples', [SampleController::class, 'index']);
Route::get('/samples/{kode_sample}', [SampleController::class, 'show']);
