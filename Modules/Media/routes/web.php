<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\MediaController;

Route::middleware(['web', 'auth'])->prefix('admin/media')->name('media.')->group(function () {
    Route::get('/', [MediaController::class, 'index'])->name('index');
    Route::post('/create-folder', [MediaController::class, 'createFolder'])->name('create-folder');
    Route::delete('/delete-folder', [MediaController::class, 'deleteFolder'])->name('delete-folder');
    Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
    Route::post('/uploads', [MediaController::class, 'uploadMulti'])->name('uploads');
    Route::delete('/delete', [MediaController::class, 'delete'])->name('delete');
    Route::post('/rename', [MediaController::class, 'rename'])->name('rename');
    Route::post('/crop', [MediaController::class, 'crop'])->name('crop');
});