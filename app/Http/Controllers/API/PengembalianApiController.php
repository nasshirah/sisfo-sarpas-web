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
            'label_status' => 'nullable|in:selesai,menunggu,penting',
        ]);

        $peminjaman = Peminjaman::with('barang')->findOrFail($request->id_peminjaman);
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
            'label_status' => $request->label_status,
        ]);

        return response()->json([
            'message' => 'Pengembalian berhasil disimpan',
            'data' => $pengembalian
        ], 201);
    }
}
