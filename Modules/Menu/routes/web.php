<?php

use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\Admin\MenuController;
use Modules\Menu\Http\Controllers\Admin\MenuItemController;

Route::middleware(['web','auth'])
    ->prefix('dashboard/menus')
    ->name('admin.menus.')
    ->group(function () {

        // Menus CRUD (index + create/store + edit/update + delete)
        Route::get('/',            [MenuController::class, 'index'])->name('index');
        Route::post('/',           [MenuController::class, 'store'])->name('store');        // create from index (modal)
        Route::get('/{id}/edit',   [MenuController::class, 'edit'])->name('edit');
        Route::put('/{id}',        [MenuController::class, 'update'])->name('update');
        Route::delete('/{id}',     [MenuController::class, 'destroy'])->name('destroy');

        // Optional: quick toggle active
        Route::patch('/{id}/toggle', [MenuController::class, 'toggle'])->name('toggle');

        // Items (unchanged)
        Route::post('/{menu}/items',      [MenuItemController::class, 'store'])->name('items.store');
        Route::put('/items/{item}',       [MenuItemController::class, 'update'])->name('items.update');
        Route::delete('/items/{item}',    [MenuItemController::class, 'destroy'])->name('items.destroy');
        Route::post('/{menu}/sync-tree',  [MenuItemController::class, 'syncTree'])->name('items.syncTree');
    });
