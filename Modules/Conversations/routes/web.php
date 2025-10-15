<?php

use Illuminate\Support\Facades\Route;
use Modules\Conversations\Http\Controllers\ConversationsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('conversations', ConversationsController::class)->names('conversations');
});
