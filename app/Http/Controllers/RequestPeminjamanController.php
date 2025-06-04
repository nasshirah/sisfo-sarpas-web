<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;

class RequestPeminjamanController extends Controller
{
    // Menampilkan semua request yang statusnya 'requested'
    public function index()
    {
        $requests = Peminjaman::with('user', 'barang')
                    ->where('status', 'diminta')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('request.index', compact('requests'));
    }

    // Approve request
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->id_barang);

        if ($barang->tersedia < $peminjaman->jumlah) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        // Update stok
        $barang->tersedia -= $peminjaman->jumlah;
        $barang->dipinjam += $peminjaman->jumlah;
        $barang->save();

        $peminjaman->status = 'disetujui';
        $peminjaman->label_status = 'selesai';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Permintaan peminjaman disetujui.');
    }

    // Decline request
    public function decline($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'ditolak';
        $peminjaman->label_status = 'penting';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Permintaan peminjaman ditolak.');
    }
}
