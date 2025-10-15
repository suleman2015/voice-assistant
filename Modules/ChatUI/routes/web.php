<?php

use Illuminate\Support\Facades\Route;
use Modules\ChatUI\Http\Controllers\ChatUIController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('chatuis', ChatUIController::class)->names('chatui');
});
