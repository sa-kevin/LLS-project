<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\WishlistController;
use App\Models\Wishlist;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('waitinglists', WaitingListController::class);
    Route::resource('wishlists', WishlistController::class);
    Route::resource('books', BookController::class);
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
});

require __DIR__.'/auth.php';
