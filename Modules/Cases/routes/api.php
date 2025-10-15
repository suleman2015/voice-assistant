<?php

use Illuminate\Support\Facades\Route;
use Modules\Cases\Http\Controllers\Api\CasesController;


Route::prefix('onc')->group(function () {
    Route::apiResource('cases', CasesController::class)->names('cases')->middleware('throttle:10,1');
});
