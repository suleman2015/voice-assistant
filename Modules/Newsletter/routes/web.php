<?php

use Illuminate\Support\Facades\Route;
use Modules\Newsletter\Http\Controllers\NewsletterController;


Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])
    ->middleware(['web']) // only web session/csrf protection
    ->name('newsletter.subscribe');

Route::prefix('admin/newsletters')->middleware(['web', 'auth'])
    ->name('admin.newsletters.')
    ->group(function () {
        Route::get('/', [NewsletterController::class, 'index'])->name('index');
        Route::delete('/{id}', [NewsletterController::class, 'destroy'])->name('destroy');
        Route::post('/store', [NewsletterController::class, 'store'])->name('newsletter.store');
    });