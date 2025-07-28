<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('landing');
Route::get('/application-form', [HomeController::class, 'application'])->name('application');
Route::post('/client/submit/form', [ClientController::class, 'store'])->name('client.submit');
Route::get('/job-titles/{categoryId}', action: [CareerController::class, 'getJobsByCategory']);
Route::get('/track-application', [HomeController::class, 'trackApplication'])->name('track.application');

