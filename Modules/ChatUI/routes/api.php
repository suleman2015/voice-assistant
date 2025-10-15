<?php

use Illuminate\Support\Facades\Route;
use Modules\ChatUI\Http\Controllers\ChatUIController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('chatuis', ChatUIController::class)->names('chatui');
});
