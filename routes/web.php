<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactRedirectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\ContactEvent;
use Illuminate\Support\Facades\Route;

// Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/umkm/{umkm}', [CatalogController::class, 'show'])->name('catalog.show');

// Pintu keluar terlacak untuk tombol WhatsApp/Shopee.
// Rute menu didaftarkan lebih dulu agar tidak tertelan pola {umkm}/{channel}.
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/go/menu/{menu}', [ContactRedirectController::class, 'menu'])->name('go.menu');
    Route::get('/go/{umkm}/{channel}', [ContactRedirectController::class, 'umkm'])
        ->whereIn('channel', ContactEvent::CHANNELS)
        ->name('go.umkm');
});

// Admin (login via Breeze). /admin/login → arahkan ke halaman login.
Route::get('/admin/login', fn () => redirect()->route('login'))->name('admin.login');

// Breeze mengarahkan ke 'dashboard' setelah login → alihkan ke panel admin.
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');
    Route::resource('umkm', UmkmController::class)->except('show');
    Route::resource('umkm.menu', MenuController::class)->except('show');
});

// Profil (bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
