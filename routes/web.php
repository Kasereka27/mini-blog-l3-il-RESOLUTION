<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/articles', 'articles')->name('articles.index');
    Route::get('/article/{slug}', 'article')->name('articles.show');
    Route::get('/categories', 'categories')->name('categories.index');
    Route::get('/about', 'about')->name('about');
});

Route::prefix('/dashboard')
    ->controller(DashboardController::class)
    ->name('dashboard.')
    ->middleware('auth'/* , 'admin' */)
    ->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/articles', 'articles')->name('articles');
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/utilisateurs', 'users')->name('users');
    Route::get('/commentaires', 'comments')->name('comments');
    Route::get('/reglages', 'settings')->name('settings');
});

require __DIR__.'/auth.php';