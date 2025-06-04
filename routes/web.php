<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RequestPeminjamanController;
use App\Http\Controllers\API\AuthApiController;

Route::get('/', function () {
    return redirect('/login');
});

// Login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Register
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id_barang}', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/barang/{id_barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id_barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id_barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
    
// Routes untuk Kategori Barang
Route::get('/kategori', [KategoriBarangController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriBarangController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriBarangController::class, 'store'])->name('kategori.store');

Route::get('/kategori/{kategori_barang}/edit', [KategoriBarangController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}', [KategoriBarangController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{kategori_barang}', [KategoriBarangController::class, 'destroy'])->name('kategori.destroy');

Route::resource('pengembalian', PengembalianController::class);

// Routes untuk peminjaman
Route::resource('peminjaman', PeminjamanController::class);
Route::get('peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
Route::get('peminjaman/{id}/decline', [PeminjamanController::class, 'decline'])->name('peminjaman.decline');

// Routes untuk request peminjaman (khusus admin)
Route::middleware(['auth'])->group(function () {
    Route::get('request', [RequestPeminjamanController::class, 'index'])->name('request.index');
    Route::get('request/{id}/approve', [RequestPeminjamanController::class, 'approve'])->name('request.approve');
    Route::get('request/{id}/decline', [RequestPeminjamanController::class, 'decline'])->name('request.decline');
});

Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])
        ->name('laporan.index');

// Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

