<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/kasir', [KasirController::class, 'index'])->name('barang.kasir');
Route::post('/kasir/tambah', [KasirController::class, 'tambah'])->name('barang.kasir.tambah');
Route::delete('/kasir/hapus/{barangId}', [KasirController::class, 'hapusItem'])->name('barang.kasir.hapus');
Route::post('/kasir', [KasirController::class, 'store'])->name('barang.kasir.store');
Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('barang.riwayat');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [BarangController::class, 'dashboard'])->name('barang.dashboard');

    Route::middleware('role:administrator')->group(function () {
        Route::get('/data-barang', [BarangController::class, 'databarang'])->name('barang.databarang');
        Route::post('/data-barang', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/data-barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/data-barang/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/data-barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });
});
