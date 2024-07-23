<?php

use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmptyPageController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'translations' => ['welcome1' => __('welcome.welcome1'),'welcome2' => __('welcome.welcome2'), 'login' => __('welcome.login'), 'register' => __('welcome.register'), 'dashboard' => __('welcome.dashboard')],
    ]);
});

Route::get('/language/{locale}', function ($locale) {
    
    if (in_array($locale, ['en', 'ja'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return Redirect::back()->with('locale_changed', true);
})->name('language.switch');

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/empty-page', [EmptyPageController::class, 'index'])->name('empty-page');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('books', BookController::class);
    Route::resource('waitinglists', WaitingListController::class);
    Route::resource('wishlists', WishlistController::class);
    
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
    
    
    Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
    Route::post('/upload', [UploadController::class, 'uploadProcess'])->name('upload.process');

    });
    
    require __DIR__.'/auth.php';