<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [BarangController::class, 'dashboard'])->name('barang.dashboard');

    Route::middleware('role:administrator')->group(function () {
        Route::get('/data-barang', [BarangController::class, 'databarang'])->name('barang.databarang');
        Route::post('/data-barang', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/data-barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/data-barang/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/data-barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });

    Route::middleware('role:operator')->group(function () {
        Route::get('/kasir', [BarangController::class, 'kasir'])->name('barang.kasir');
    });

});