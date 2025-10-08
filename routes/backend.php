<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
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
            Route::get('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
            Route::delete('categories/{id}/forceDelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
            Route::delete('categories-delete-all', [CategoryController::class, 'deleteAll'])->name('categories.deleteAll');
            Route::get('categories-export', [CategoryController::class, 'export'])->name('categories.export');

            // Products Routes
            Route::resource('/products', ProductController::class)->names('products');
            Route::put('products/{id}/sale-price', [ProductController::class, 'change_sale_price'])->name('products.salePrice');
            Route::get('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
            Route::delete('products/{id}/forceDelete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
            Route::delete('products-delete-all', [ProductController::class, 'deleteAll'])->name('products.deleteAll');
            Route::get('products-export', [ProductController::class, 'export'])->name('products.export');

            // Clients Routes
            Route::resource('/clients', ClientController::class)->names('clients');
            Route::get('clients/{id}/restore', [ClientController::class, 'restore'])->name('clients.restore');
            Route::delete('clients/{id}/forceDelete', [ClientController::class, 'forceDelete'])->name('clients.forceDelete');
            Route::delete('clients-delete-all', [ClientController::class, 'deleteAll'])->name('clients.deleteAll');

        }); // end of dashboard routes

    }
);


require __DIR__ . '/auth.php';
