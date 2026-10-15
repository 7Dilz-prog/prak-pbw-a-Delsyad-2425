<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PesanTamuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\SettingController;

// 1. Rute Publik
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/bukutamu', [PesanTamuController::class, 'index'])->name('bukutamu.index');
Route::post('/bukutamu', [PesanTamuController::class, 'store'])->name('bukutamu.store');

// 2. Rute Terproteksi Auth & Verified
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Breeze Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Kegiatan
    Route::resource('kegiatan', KegiatanController::class);

    // Buku Tamu (Admin)
    Route::get('/admin/bukutamu', [PesanTamuController::class, 'adminIndex'])->name('bukutamu.admin.index');
    Route::delete('/admin/bukutamu/{pesanTamu}', [PesanTamuController::class, 'destroy'])->name('bukutamu.admin.destroy');

    // Pengaturan Website
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';