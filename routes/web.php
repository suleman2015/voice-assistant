<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

Route::get('/', [WebController::class, 'index'])->name('home');
// Route::get('/blogs/{slug}', [WebController::class, 'categoryPage'])->name('categoryPage');
// Route::get('/contact-us', [WebController::class, 'contact'])->name('contact');
// Route::get('/live-events', [WebController::class, 'liveEvents'])->name('liveEvents');
// Route::get('/upcoming-events', [WebController::class, 'upcomingEvents'])->name('upcomingEvents');
// Route::get('/privacy-policy', [WebController::class, 'privacyPolicy'])->name('privacyPolicy');
// Route::get('/terms-and-conditions', [WebController::class, 'termsAndConditions'])->name('termsAndConditions');
// Route::get('/cookie-policy', [WebController::class, 'cookiePolicy'])->name('cookiePolicy');
// Route::get('/user-cases', [WebController::class, 'userCases'])->name('userCases');
// Route::get('/rahul-gosain-md', [WebController::class, 'rahulGosainMd'])->name('rahulGosainMd');
// Route::get('/rohit-gosain-md', [WebController::class, 'rohitGosainMd'])->name('rohitGosainMd');
// Route::get('/{slug}', [WebController::class, 'postPage'])->name('postPage');
