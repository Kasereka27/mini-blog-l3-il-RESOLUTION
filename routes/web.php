<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/articles', 'articles')->name('articles.index');
    Route::get('/articles/{slug}', 'article')->name('articles.show');
    Route::get('/categories', 'categories')->name('categories.index');
    Route::get('/about', 'about')->name('about');
});

Route::prefix('/dashboard')
    ->controller(DashboardController::class)
    ->name('dashboard.')
    ->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('/articles', 'articles')->name('articles');
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/utilisateurs', 'comments')->name('users');
    Route::get('/commentaires', 'about')->name('comments');
    Route::get('/reglages', 'settings')->name('settings');
});