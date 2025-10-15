<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\SettingController;

Route::middleware(['auth', 'verified'])->prefix('dashboard/settings')->group(function () {
    Route::resource('/', SettingController::class)->names('setting')->except(['update']);
    Route::post('/update', [SettingController::class, 'updateSettings'])->name('setting.update');
    Route::get('smtp', [SettingController::class, 'smtp'])->name('setting.smtp');
    Route::get('modules-setting', [SettingController::class, 'moduleSettings'])->name('setting.modules_setting');
    Route::get('website-tracking', [SettingController::class, 'websiteTracking'])->name('setting.website_tracking');
    Route::get('site-appearence', [SettingController::class, 'siteAppearence'])->name('site.appearance');
});

