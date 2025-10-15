<?php

use Illuminate\Support\Facades\Route;
use Modules\Conversations\Http\Controllers\ConversationsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('conversations', ConversationsController::class)->names('conversations');
});
