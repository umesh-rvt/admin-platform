<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Frontend pages
Route::get('/pages/{page:slug}', [FrontendPageController::class, 'show'])->name('pages.show');
Route::get('/contact', [FrontendContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [FrontendContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include admin routes
require __DIR__.'/admin.php';

require __DIR__.'/auth.php';
