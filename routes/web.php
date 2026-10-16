<?php

use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/about/struktur-organisasi', [PageController::class, 'strukturOrganisasi'])->name('about.struktur-organisasi');
Route::get('/about/sumber-daya-manusia', [PageController::class, 'sdm'])->name('about.sdm');
Route::get('/about/sumber-daya-manusia/{staff}', [PageController::class, 'sdmShow'])->name('about.sdm.show');

Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');

Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('artikel.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('login.store');
});

Route::middleware('auth')->post('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin', 'throttle:300,1'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::patch('/content/{section}/{key}', [ContentController::class, 'update'])->name('content.update');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}/read', [MessageController::class, 'markRead'])->name('messages.read');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Generic collection CRUD — see config/ecms.php for the registry of
    // {resource} slugs this accepts (features, staff, articles, ...).
    Route::post('/{resource}/reorder', [CollectionController::class, 'reorder'])->name('collection.reorder');
    Route::patch('/{resource}/{id}/status', [CollectionController::class, 'status'])->name('collection.status');
    Route::get('/{resource}', [CollectionController::class, 'index'])->name('collection.index');
    Route::post('/{resource}', [CollectionController::class, 'store'])->name('collection.store');
    Route::match(['put', 'patch'], '/{resource}/{id}', [CollectionController::class, 'update'])->name('collection.update');
    Route::delete('/{resource}/{id}', [CollectionController::class, 'destroy'])->name('collection.destroy');
});
