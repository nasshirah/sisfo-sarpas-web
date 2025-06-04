<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\BarangApiController;
use App\Http\Controllers\Api\PeminjamanApiController;
use App\Http\Controllers\Api\PengembalianApiController;



// Auth Routes

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthApiController::class, 'user']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
});

Route::get('/barang', [BarangApiController::class, 'index']);
Route::get('/barang/{id}', [BarangApiController::class, 'show']);

// Barang
Route::get('/barang', [BarangController::class, 'apiIndex']);
Route::get('/barang/{id}', [BarangController::class, 'apiShow']);
Route::post('/barang', [BarangController::class, 'apiStore']);
Route::put('/barang/{id}', [BarangController::class, 'apiUpdate']);
Route::delete('/barang/{id}', [BarangController::class, 'apiDestroy']);

// Kategori
Route::get('/kategori', [KategoriBarangController::class, 'apiIndex']);
Route::get('/kategori/{id}', [KategoriBarangController::class, 'apiShow']);
Route::post('/kategori', [KategoriBarangController::class, 'apiStore']);
Route::put('/kategori/{id}', [KategoriBarangController::class, 'apiUpdate']);
Route::delete('/kategori/{id}', [KategoriBarangController::class, 'apiDestroy']);

// Peminjaman
Route::get('/peminjaman', [PeminjamanApiController::class, 'index']);
Route::get('/peminjaman/{id}', [PeminjamanApiController::class, 'show']);
Route::post('/peminjaman', [PeminjamanApiController::class, 'store']);

// Pengembalian

Route::get('/pengembalian', [PengembalianApiController::class, 'index']);
Route::post('/pengembalian', [PengembalianApiController::class, 'store']);
