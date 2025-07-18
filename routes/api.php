<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ClientDocumentController;
use App\Http\Controllers\ApplicationPaymentController;
use App\Http\Controllers\Api\Authentication\AuthController;

// Auth routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

// Resource routes
Route::apiResource('users', UserController::class);
Route::apiResource('clients', ClientController::class);
Route::apiResource('application-payments', ApplicationPaymentController::class);
Route::apiResource('applications', ApplicationController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('clientdocs', ClientDocumentController::class);
Route::apiResource( 'statuses', StatusController::class);


// Custom routes
Route::get('/clientdocs/client/{client}', [ClientDocumentController::class, 'getByClient']);
