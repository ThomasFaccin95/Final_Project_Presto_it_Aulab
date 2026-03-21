<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');
// Search before show method
Route::get('/articles/search', [ArticleController::class, 'search'])->name('article.search');
// Articles routes
Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
Route::post('/article', [ArticleController::class, 'store'])->name('article.store');
Route::get('/show/article/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/article/{article}/edit', [ArticleController::class, 'edit'])->name('article.edit');
Route::put('/article/{article}', [ArticleController::class, 'update'])->name('article.update');
Route::delete('/article/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');
// Articles by category
Route::get('/articles/category/{category}', [ArticleController::class, 'byCategory'])->name('article.byCategory');


// Proctected routes - Auth
Route::middleware('auth')->group(function () {
    Route::get('/article/create', function () {
        return view('article.create');
    })->name('article.create');
});
