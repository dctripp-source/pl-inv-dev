<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Business routes
Route::prefix('biznisi')->name('business.')->group(function () {
    Route::get('/', [BusinessController::class, 'index'])->name('index');
    Route::get('/prijavi', [BusinessController::class, 'create'])->name('create');
    Route::post('/prijavi', [BusinessController::class, 'store'])->name('store');
    Route::get('/uspeh', [BusinessController::class, 'success'])->name('success');
    Route::get('/{slug}', [BusinessController::class, 'show'])->name('show');
});

// Category routes
Route::prefix('kategorije')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('show');
});