<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\BarangMasukController;
use Illuminate\Support\Facades\Route;

// --- ROUTE PUBLIK ---
Route::get('/', [AuthController::class, 'main'])->name('main');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- ROUTE WAJIB LOGIN ---
Route::middleware('auth')->group(function () {

    // BISA DIAKSES SEMUA ROLE (Admin & Operator)
    Route::get('/dashboard', [BarangController::class, 'dashboard'])->name('barang.dashboard');

    // KHUSUS ADMINISTRATOR SAJA (Operator tidak bisa akses)
    Route::middleware('role:administrator')->group(function () {
        // Data Barang
        Route::get('/data-barang', [BarangController::class, 'databarang'])->name('barang.databarang');
        Route::post('/data-barang', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/data-barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/data-barang/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/data-barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

        // Master Gudang
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
        Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.store');
        Route::get('/gudang/{id}/edit', [GudangController::class, 'edit'])->name('gudang.edit');
        Route::put('/gudang/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::delete('/gudang/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');
    });

    // DIAKSES BERSAMA (ADMINISTRATOR & OPERATOR)
    Route::middleware('role:administrator,operator')->group(function () {
        // Fitur Kasir / Pembelian
        Route::get('/kasir', [KasirController::class, 'index'])->name('barang.kasir');
        Route::post('/kasir/tambah', [KasirController::class, 'tambah'])->name('barang.kasir.tambah');
        Route::delete('/kasir/hapus/{barangId}', [KasirController::class, 'hapusItem'])->name('barang.kasir.hapus');
        Route::post('/kasir', [KasirController::class, 'store'])->name('barang.kasir.store');

        // Riwayat Transaksi
        Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('barang.riwayat');

        // Barang Masuk
        Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::post('/barang-masuk/tambah', [BarangMasukController::class, 'tambah'])->name('barang-masuk.tambah');
        Route::delete('/barang-masuk/hapus/{barangId}', [BarangMasukController::class, 'hapusItem'])->name('barang-masuk.hapus');
        Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
    });

});