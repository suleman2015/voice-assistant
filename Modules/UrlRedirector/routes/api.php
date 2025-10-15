<?php

use Illuminate\Support\Facades\Route;
use Modules\UrlRedirector\Http\Controllers\Api\UrlRedirectorController;


Route::prefix('onc')->group(function () {
    Route::apiResource('/url-redirects', UrlRedirectorController::class)->names('urlredirector');
});
