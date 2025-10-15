<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\ContactController;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('contacts', ContactController::class)->names('contact');
    Route::post('contacts/{id}/status', [ContactController::class, 'updateStatus'])->name('contact.updateStatus');
});
Route::post('contacts/submit', [ContactController::class, 'store'])
    ->name('contact.submit')
    ->middleware(['recaptcha:contact-form', 'throttle:5,1']); // 5 submissions / minute per IP
