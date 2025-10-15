<?php

use Illuminate\Support\Facades\Route;
use Modules\Cases\Http\Controllers\CasesController;

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::resource('cases', CasesController::class)->names('cases');
    Route::put('/cases/{id}/status', [CasesController::class, 'updateStatus'])->name('cases.updateStatus');
});