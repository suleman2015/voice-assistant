<?php

use Illuminate\Support\Facades\Route;
use Modules\Recaptcha\Http\Controllers\RecaptchaController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::resource('recaptchas', RecaptchaController::class)->names('recaptcha');
});


Route::prefix('dashboard/recaptcha')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [RecaptchaController::class, 'index'])->name('recaptcha.settings.index');
    Route::post('/update', [RecaptchaController::class, 'updateSettings'])->name('recaptcha.settings.update');
    Route::post('/forms/toggle/{id}', [RecaptchaController::class, 'toggleForm']);
});
