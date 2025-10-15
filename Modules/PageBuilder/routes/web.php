<?php

use Illuminate\Support\Facades\Route;
use Modules\PageBuilder\Http\Controllers\PageBuilderController;
use Modules\PageBuilder\Http\Controllers\PageComponentController;
use Modules\PageBuilder\Http\Controllers\PageComponentItemController;
use Modules\PageBuilder\Http\Controllers\PageController;



Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::resource('pages', PageController::class)->except('show')->names('pages');
    // Route::get('{setting_type}', [PageController::class, 'settingType'])->name('setting-type');
    Route::resource('components', PageComponentController::class)->except('show')->names('components');
    Route::get('component-filter', [PageComponentController::class, 'componentFilter'])->name('page.builder.component.filter');
    Route::resource('component-item', PageComponentItemController::class)->except(['index', 'show']);
});

Route::get('test/{slug?}', [PageBuilderController::class, 'show'])
    ->name('page.show'); 
