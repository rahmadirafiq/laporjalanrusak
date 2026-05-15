<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// Landing
Route::get('/', fn() => view('landing'))->name('landing');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Laporan (bisa diakses tamu & login)
Route::get('/laporan/buat',    [LaporanController::class, 'form'])->name('laporan.form');
Route::post('/laporan/buat',   [LaporanController::class, 'store'])->name('laporan.store');

// Laporan butuh login
Route::middleware('auth')->group(function () {
    Route::get('/laporan/riwayat',      [LaporanController::class, 'riwayat'])->name('laporan.riwayat');
    Route::get('/laporan/{id}',         [LaporanController::class, 'detail'])->name('laporan.detail');
    Route::delete('/laporan/{id}',      [LaporanController::class, 'destroy'])->name('laporan.destroy');

    Route::get('/profil',                       [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil/update',               [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/password',             [ProfilController::class, 'updatePassword'])->name('profil.password');
    Route::post('/profil/notifikasi',           [ProfilController::class, 'updateNotifikasi'])->name('profil.notifikasi');
});

// ===================== ADMIN =====================
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\Admin\UserAdminController;

// Login admin (tanpa middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AdminController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminController::class, 'login']);

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::post('logout',    [AdminController::class, 'logout'])->name('logout');
        Route::get('dashboard',  [AdminController::class, 'dashboard'])->name('dashboard');

        // Laporan
        Route::get('laporan',              [LaporanAdminController::class, 'index'])->name('laporan.index');
        Route::get('laporan/{id}',         [LaporanAdminController::class, 'detail'])->name('laporan.detail');
        Route::post('laporan/{id}/status', [LaporanAdminController::class, 'updateStatus'])->name('laporan.status');
        Route::delete('laporan/{id}',      [LaporanAdminController::class, 'destroy'])->name('laporan.destroy');
        Route::get('laporan-export',       [LaporanAdminController::class, 'export'])->name('laporan.export');

        // Users
        Route::get('users',        [UserAdminController::class, 'index'])->name('users.index');
        Route::delete('users/{id}',[UserAdminController::class, 'destroy'])->name('users.destroy');
    });
});