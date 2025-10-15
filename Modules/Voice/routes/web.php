<?php

use Illuminate\Support\Facades\Route;
use Modules\Voice\Http\Controllers\VoiceController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('voices', VoiceController::class)->names('voice');
});
