<?php

use Illuminate\Support\Facades\Route;
use Modules\Recaptcha\Http\Controllers\RecaptchaController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('recaptchas', RecaptchaController::class)->names('recaptcha');
});
