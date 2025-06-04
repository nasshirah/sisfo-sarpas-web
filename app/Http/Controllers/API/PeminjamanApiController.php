<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Log;
use App\Models\Barang;
use Illuminate\Validation\ValidationException;

class PeminjamanApiController extends Controller
{
    /**
     * Tampilkan semua peminjaman milik user yang sedang login
     */
    public function index(Request $request)
    {
        try {
            // Ambil id_user dari request atau auth
            $id_user = $request->input('id_user');

            if (!$id_user) {
                return response()->json([
                    'message' => 'ID User diperlukan'
                ], 400);
            }

            $data = Peminjaman::with(['user', 'barang'])
                ->where('id_user', $id_user)
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'message' => 'Data peminjaman berhasil diambil',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting peminjaman:', [
                'message' => $e->getMessage(),
                'user_id' => $request->input('id_user')
            ]);

            return response()->json([
                'message' => 'Gagal mengambil data peminjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buat peminjaman baru
     */
    public function store(Request $request)
    {
        try {
            // Debug log
            Log::info('Creating peminjaman with data:', $request->all());

            // Validasi input
            $validated = $request->validate([
                'id_user' => 'required|exists:users,id_user',
                'id_barang' => 'required|exists:barang,id_barang',
                'jumlah' => 'required|integer|min:1',
                'tanggal_pinjam' => 'required|date',
                'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            ]);

            // Cek apakah barang tersedia
            $barang = Barang::where('id_barang', $validated['id_barang'])->first();

            if (!$barang) {
                return response()->json([
                    'message' => 'Barang tidak ditemukan'
                ], 404);
            }

            // Cek stok
            if ($barang->tersedia < $validated['jumlah']) {
                return response()->json([
                    'message' => 'Stok barang tidak mencukupi',
                    'tersedia' => $barang->tersedia,
                    'diminta' => $validated['jumlah']
                ], 422);
            }

            // Buat peminjaman baru
            $peminjaman = Peminjaman::create([
                'id_user' => $validated['id_user'],
                'id_barang' => $validated['id_barang'],
                'jumlah' => $validated['jumlah'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'] ?? null, // ✅ ini perbaikan aman
                'status' => 'diminta',
                'label_status' => 'menunggu'
            ]);


            // Load relationships untuk response
            $peminjaman->load(['user', 'barang']);

            Log::info('Peminjaman created successfully:', ['id' => $peminjaman->id_peminjaman]);

            return response()->json([
                'message' => 'Peminjaman berhasil dibuat',
                'data' => $peminjaman
            ], 201);
        } catch (ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating peminjaman:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'message' => 'Gagal membuat peminjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan detail peminjaman (optional, jika diperlukan)
     */
    public function show($id, Request $request)
    {
        try {
            $id_user = $request->input('id_user');

            $peminjaman = Peminjaman::with(['user', 'barang'])
                ->where('id_peminjaman', $id)
                ->where('id_user', $id_user) // pastikan user hanya bisa lihat peminjaman mereka
                ->first();

            if (!$peminjaman) {
                return response()->json([
                    'message' => 'Peminjaman tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Detail peminjaman berhasil diambil',
                'data' => $peminjaman
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting peminjaman detail:', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return response()->json([
                'message' => 'Gagal mengambil detail peminjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
