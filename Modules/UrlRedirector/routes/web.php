<?php

use Illuminate\Support\Facades\Route;
use Modules\UrlRedirector\Http\Controllers\UrlRedirectorController;

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::resource('urlredirectors', UrlRedirectorController::class)->names('urlredirector');
});
