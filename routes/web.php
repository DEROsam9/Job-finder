<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\TrackApplicationController;


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('landing');
Route::get('/application-form', [HomeController::class, 'application'])->name('application');
Route::post('/client/submit/form', [ClientController::class, 'store'])->name('client.submit');
Route::get('/job-titles/{categoryId}', action: [CareerController::class, 'getJobsByCategory']);
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('patners', [HomeController::class, 'patners'])->name('patners');
Route::get('testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('service', [HomeController::class, 'service'])->name('service');

Route::get('/track-application', [HomeController::class, 'trackApplication'])->name('track.application');

Route::get('/application-success/{reference}', [\App\Http\Controllers\ClientController::class, 'applicationSuccess'])->name('application.success');
Route::name('track.')->group(function () {
    Route::get('/track-app', [TrackApplicationController::class, 'showForm'])->name('form');
    Route::post('/track-app', [TrackApplicationController::class, 'track'])->name('search');
});