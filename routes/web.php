<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RevisorController;
use App\Http\Controllers\CartController;



Route::get('/', [PublicController::class, 'homepage'])->name('homepage');

// Cambio lingua — salva in sessione
Route::get('/lang/{locale}', [PublicController::class, 'setLocale'])->name('lang.switch');
// Lavora con noi — pubblica
Route::get('/work-with-us', [PublicController::class, 'workWithUs'])->name('work-with-us');

Route::get('/regulations', fn() => view('regulations'))->name('regulations');

// Invio richiesta revisore — solo utenti loggati
Route::post('/work-with-us', [PublicController::class, 'sendRevisorRequest'])->name('work-with-us.send')->middleware('auth');

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

// Revisor routes -Auth, middleware revisor
Route::middleware(['auth', 'revisor'])->prefix('revisor')->group(function () {
    Route::get('/', [RevisorController::class, 'index'])->name('revisor.index');
    Route::post('/approve/{article}', [RevisorController::class, 'approve'])->name('revisor.approve');
    Route::post('/reject/{article}', [RevisorController::class, 'reject'])->name('revisor.reject');
    Route::post('/undo', [RevisorController::class, 'undo'])->name('revisor.undo');
});

// Rotte carrello — solo utenti loggati
Route::middleware('auth')->group(function () {
    Route::get('/my-articles', [ArticleController::class, 'myArticles'])->name('article.my');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{article}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});
