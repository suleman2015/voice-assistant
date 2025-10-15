<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('blogs', BlogController::class)->names('blog');
});

  Route::get('/get-suggestions/{keywords}', [BlogController::class, 'get_suggestions'])->name('get_suggestions');
  Route::get('/get-blogs-suggestions/{keywords}', [BlogController::class, 'get_blogs'])->name('get_blogs');