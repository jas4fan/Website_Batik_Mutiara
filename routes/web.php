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

    // Di dalam group prefix admin
    Route::get('/penjualan', [AdminController::class, 'laporanPenjualan'])->name('admin.penjualan');
    Route::get('/penjualan/{id}/edit', [AdminController::class, 'editPenjualan'])->name('admin.penjualan.edit');
    Route::put('/penjualan/{id}', [AdminController::class, 'updatePenjualan'])->name('admin.penjualan.update');
    // Route::delete('/penjualan/{id}', [AdminController::class, 'destroyPenjualan'])->name('admin.penjualan.destroy');
});

// 3. Group Route Khusus Kasir
Route::middleware(['auth:kasir'])->prefix('kasir')->group(function () {
    // Dashboard & Transaksi
    Route::get('/transaksi', [App\Http\Controllers\TransaksiController::class, 'index'])->name('kasir.transaksi');
    Route::post('/transaksi/add', [App\Http\Controllers\TransaksiController::class, 'addToCart'])->name('kasir.transaksi.add');
    Route::get('/transaksi/delete/{id}', [App\Http\Controllers\TransaksiController::class, 'removeFromCart'])->name('kasir.transaksi.delete');
    Route::post('/transaksi/checkout', [App\Http\Controllers\TransaksiController::class, 'checkout'])->name('kasir.transaksi.checkout');
    
    Route::get('/dashboard', function() {
        return redirect()->route('kasir.transaksi');
    })->name('kasir.dashboard');

    Route::get('/riwayat', [App\Http\Controllers\TransaksiController::class, 'riwayat'])->name('kasir.riwayat');

    // === PERBAIKAN: DEFINISI ROUTE PRODUK SECARA MANUAL ===
    // 1. Tampilkan Halaman Produk Kasir
    Route::get('/produk', [App\Http\Controllers\ProdukController::class, 'index'])->name('kasir.produk.index');
    // 2. Simpan Produk Baru (POST)
    Route::post('/produk', [App\Http\Controllers\ProdukController::class, 'store'])->name('kasir.produk.store');
    // 3. Update Produk (PUT)
    Route::put('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'update'])->name('kasir.produk.update');
    // 4. Hapus Produk (DELETE)
    Route::delete('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'destroy'])->name('kasir.produk.destroy');
});