<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UsersController::class)->names('users')->middleware([
        'index'   => 'can:user.index',
        'create'  => 'can:user.create',
        'store'   => 'can:user.create',
        'edit'    => 'can:user.edit',
        'update'  => 'can:user.edit',
        'destroy' => 'can:user.delete',
        'show'    => 'can:user.show',
    ]);
});
