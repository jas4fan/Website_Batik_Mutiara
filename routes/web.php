<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini adalah routing untuk Aplikasi PT Batik Mutiara.
| Route '/' diarahkan langsung ke Login.
|
*/

// 1. Halaman Utama adalah LOGIN (Menggantikan welcome screen default)
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Group Route Khusus Admin
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen Kasir (CRUD)
    Route::get('/kasir', [AdminController::class, 'indexKasir'])->name('admin.kasir.index');
    Route::post('/kasir', [AdminController::class, 'storeKasir'])->name('admin.kasir.store');
    Route::put('/kasir/{id}', [AdminController::class, 'updateKasir'])->name('admin.kasir.update');
    Route::delete('/kasir/{id}', [AdminController::class, 'destroyKasir'])->name('admin.kasir.destroy');

    // Manajemen Produk (CRUD)
    Route::resource('produk', ProdukController::class);
    
    // Laporan Penjualan (Placeholder jika belum dibuat controller khususnya)
    Route::get('/penjualan', function() {
        return "Halaman Laporan Penjualan (Akan Datang)";
    })->name('admin.penjualan');

    // Di dalam group prefix admin
    Route::get('/penjualan', [AdminController::class, 'laporanPenjualan'])->name('admin.penjualan');
    Route::get('/penjualan/{id}/edit', [AdminController::class, 'editPenjualan'])->name('admin.penjualan.edit');
    Route::put('/penjualan/{id}', [AdminController::class, 'updatePenjualan'])->name('admin.penjualan.update');
    Route::delete('/penjualan/{id}', [AdminController::class, 'destroyPenjualan'])->name('admin.penjualan.destroy');
});

// 3. Group Route Khusus Kasir
Route::middleware(['auth:kasir'])->prefix('kasir')->group(function () {
    // Dashboard/Transaksi Kasir
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('kasir.transaksi');
    Route::post('/transaksi/add', [TransaksiController::class, 'addToCart'])->name('kasir.transaksi.add');
    Route::get('/transaksi/delete/{id}', [TransaksiController::class, 'removeFromCart'])->name('kasir.transaksi.delete');
    Route::post('/transaksi/checkout', [TransaksiController::class, 'checkout'])->name('kasir.transaksi.checkout');
    
    // CRU Produk untuk Kasir
    Route::resource('produk', ProdukController::class)->names('kasir.produk');
    // Rekap Penjualan Saya
    Route::get('/riwayat', [App\Http\Controllers\TransaksiController::class, 'riwayat'])->name('kasir.riwayat');
    // Redirect dashboard kasir ke transaksi
    Route::get('/dashboard', function() {
        return redirect()->route('kasir.transaksi');
    })->name('kasir.dashboard');
});