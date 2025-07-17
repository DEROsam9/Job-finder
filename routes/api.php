<?php

use App\Http\Controllers\Api\Authentication\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\JobCategoryController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);


Route::resource('careers', CareerController::class);
Route::resource('job-categories', JobCategoryController::class);


