<?php

use App\Http\Controllers\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'verified'],
    ],
    function () {

        Route::prefix('dashboard')->name('dashboard.')->group(function () {

            Route::get('/index', [DashboardController::class, 'index'])->name('index');

            // Users Routes
            Route::resource('/users', UserController::class)->names('users');
            Route::delete('users-delete-all', [UserController::class, 'deleteAll'])->name('users.deleteAll');

            // Categories Routes
            Route::resource('/categories', CategoryController::class)->names('categories');
            //
            Route::get('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
            // Route::delete('/category/{category}/forceDelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        }); // end of dashboard routes

    }
);


require __DIR__ . '/auth.php';
