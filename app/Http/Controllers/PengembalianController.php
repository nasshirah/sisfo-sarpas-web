<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.barang')->get();
        return view('pengembalian.index', compact('pengembalian'));
    }

    public function create()
    {
        $peminjaman = Peminjaman::whereDoesntHave('pengembalian')->get();
        return view('pengembalian.create', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required',
            'tanggal_kembali' => 'required|date',
        ]);

        $peminjaman = Peminjaman::with('barang')->findOrFail($request->id_peminjaman);

        // Cek apakah peminjaman sudah dikembalikan
        if ($peminjaman->pengembalian) {
            return redirect()->back()->with('error', 'Barang dari peminjaman ini sudah dikembalikan sebelumnya.');
        }

        // Cek apakah peminjaman sudah disetujui
        if ($peminjaman->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Peminjaman belum disetujui dan tidak dapat dikembalikan.');
        }

        $barang = $peminjaman->barang;

        $barang->tersedia += $peminjaman->jumlah;
        $barang->dipinjam -= $peminjaman->jumlah;
        $barang->save();

        Pengembalian::create($request->all());

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil disimpan.');
    }

    public function show(Pengembalian $pengembalian)
    {
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'label_status' => 'nullable|in:selesai,menunggu,damage'
        ]);


        $pengembalian->update($request->all());
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $peminjaman = $pengembalian->peminjaman;
        $barang = $peminjaman->barang;

        $barang->tersedia -= $peminjaman->jumlah;
        $barang->dipinjam += $peminjaman->jumlah;
        $barang->save();

        $pengembalian->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian dihapus dan stok diperbarui.');
    }

    public function apiIndex()
    {
        return response()->json(Pengembalian::with('peminjaman')->get());
    }

    public function apiShow($id)
    {
        $pengembalian = Pengembalian::find($id);
        if (!$pengembalian) {
            return response()->json(['message' => 'Pengembalian tidak ditemukan'], 404);
        }
        return response()->json($pengembalian);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'tanggal_kembali' => 'required|date',
        ]);

        $peminjaman = Peminjaman::with('barang')->findOrFail($request->id_peminjaman);

        // Cek apakah peminjaman sudah dikembalikan
        if ($peminjaman->pengembalian) {
            return response()->json([
                'message' => 'Barang dari peminjaman ini sudah dikembalikan sebelumnya.'
            ], 400);
        }

        // Cek apakah peminjaman sudah disetujui
        if ($peminjaman->status !== 'disetujui') {
            return response()->json([
                'message' => 'Peminjaman belum disetujui dan tidak dapat dikembalikan.'
            ], 400);
        }

        $pengembalian = Pengembalian::create($request->all());
        return response()->json(['message' => 'Pengembalian berhasil ditambahkan', 'data' => $pengembalian], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $pengembalian = Pengembalian::find($id);
        if (!$pengembalian) {
            return response()->json(['message' => 'Pengembalian tidak ditemukan'], 404);
        }
        $pengembalian->update($request->all());
        return response()->json(['message' => 'Pengembalian berhasil diperbarui', 'data' => $pengembalian]);
    }

    public function apiDestroy($id)
    {
        $pengembalian = Pengembalian::find($id);
        if (!$pengembalian) {
            return response()->json(['message' => 'Pengembalian tidak ditemukan'], 404);
        }
        $pengembalian->delete();
        return response()->json(['message' => 'Pengembalian berhasil dihapus']);
    }

    public function approve($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $pengembalian->update([
            'label_status' => 'selesai'
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil disetujui.');
    }

    public function damage(Request $request, $id)
    {
        $request->validate([
            'denda' => 'required|numeric|min:0'
        ]);

        $pengembalian = Pengembalian::findOrFail($id);

        $pengembalian->update([
            'label_status' => 'damage',
            'denda' => $request->denda
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Status damage berhasil diterapkan dengan denda Rp ' . number_format($request->denda, 0, ',', '.'));
    }
}
