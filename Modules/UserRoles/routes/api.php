<?php

use Illuminate\Support\Facades\Route;
use Modules\UserRoles\Http\Controllers\UserRolesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('userroles', UserRolesController::class)->names('userroles');
});
