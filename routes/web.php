<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/umkm/{umkm}', [CatalogController::class, 'show'])->name('catalog.show');

// Admin (login via Breeze). /admin/login → arahkan ke halaman login.
Route::get('/admin/login', fn () => redirect()->route('login'))->name('admin.login');

// Breeze mengarahkan ke 'dashboard' setelah login → alihkan ke panel admin.
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('umkm', UmkmController::class)->except('show');
});

// Profil (bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
