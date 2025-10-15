<?php

use Illuminate\Support\Facades\Route;
use Modules\UserRoles\Http\Controllers\PermissionController;
use Modules\UserRoles\Http\Controllers\RoleController;
use Modules\UserRoles\Http\Controllers\UserRolesController;



Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('userroles', UserRolesController::class)->names('userroles');
    // Permissions CRUD
    Route::prefix('dashboard')->group(function () {
        Route::resource('permissions', PermissionController::class)->names('permissions')->middleware([
            'index'   => 'can:permission.index',
            'create'  => 'can:permission.create',
            'store'   => 'can:permission.create',
            'edit'    => 'can:permission.edit',
            'update'  => 'can:permission.edit',
            'destroy' => 'can:permission.delete',
            'show'    => 'can:permission.show',
        ]);

        // Roles CRUD
        Route::resource('roles', RoleController::class)->names('roles')->middleware([
            'index'   => 'can:role.index',
            'create'  => 'can:role.create',
            'store'   => 'can:role.create',
            'edit'    => 'can:role.edit',
            'update'  => 'can:role.edit',
            'destroy' => 'can:role.delete',
            'show'    => 'can:role.show',
        ]);
    });
});
