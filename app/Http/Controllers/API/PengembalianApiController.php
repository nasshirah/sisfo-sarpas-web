<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;

class PengembalianApiController extends Controller
{
    // GET /api/pengembalian
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.barang')->get();

        return response()->json([
            'message' => 'Data pengembalian berhasil diambil',
            'data' => $pengembalian
        ]);
    }

    // POST /api/pengembalian
    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'tanggal_kembali' => 'required|date',
            'keterangan' => 'nullable|string',
            'label_status' => 'nullable|in:selesai,menunggu,damage',
        ]);

        // Ambil data peminjaman
        $peminjaman = Peminjaman::with('barang')->findOrFail($request->id_peminjaman);

        // Cek apakah peminjaman sudah dikembalikan
        if ($peminjaman->pengembalian) {
            return response()->json([
                'message' => 'Barang dari peminjaman ini sudah dikembalikan sebelumnya.'
            ], 400);
        }

        // Validasi status peminjaman
        if ($peminjaman->status !== 'disetujui') {
            return response()->json([
                'message' => 'Peminjaman belum disetujui dan tidak dapat dikembalikan.'
            ], 400);
        }

        $barang = $peminjaman->barang;

        // Update stok barang
        $barang->tersedia += $peminjaman->jumlah;
        $barang->dipinjam -= $peminjaman->jumlah;
        $barang->save();

        // Simpan data pengembalian
        $pengembalian = Pengembalian::create([
            'id_peminjaman' => $request->id_peminjaman,
            'tanggal_kembali' => $request->tanggal_kembali,
            'keterangan' => $request->keterangan,
            'label_status' => $request->label_status ?? 'menunggu',
        ]);

        return response()->json([
            'message' => 'Pengembalian berhasil disimpan',
            'data' => $pengembalian
        ], 201);
    }
}
