<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\CategoryController;
use Modules\Blog\Http\Controllers\PostController;
use Modules\Blog\Http\Controllers\TagController;

Route::middleware(['auth', 'verified'])->prefix('dashboard/blogs')->group(function () {
    Route::resource('blogs', BlogController::class)->names('blog');
    Route::resource('posts', PostController::class)->names('posts');
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('tags', TagController::class)->names('tags');
    Route::get('/slug/check', [BlogController::class, 'check'])->name('slug.check');
});