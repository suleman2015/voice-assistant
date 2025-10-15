<?php

use Illuminate\Support\Facades\Route;
use Modules\Voice\Http\Controllers\VoiceController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('voices', VoiceController::class)->names('voice');
});
