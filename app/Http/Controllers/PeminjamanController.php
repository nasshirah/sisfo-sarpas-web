<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('barang', 'user')->get();
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::where('tersedia', '>', 0)->get();
        $user = User::all();
        return view('peminjaman.create', compact('barang', 'user'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_user' => 'required',
        'id_barang' => 'required',
        'jumlah' => 'required|integer|min:1',
        'tanggal_pinjam' => 'required|date',
        'keterangan' => 'required'
    ]);

    // Jangan kurangi stok dulu, tunggu approve
    $data = Peminjaman::create([
        'id_user' => $request->id_user,
        'id_barang' => $request->id_barang,
        'jumlah' => $request->jumlah,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'status' => 'diminta',
        'label_status' => 'menunggu',
    ]);
   

    return redirect()->route('peminjaman.index')->with('success', 'Permintaan peminjaman dikirim, menunggu persetujuan admin.');
}


    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $barang = Barang::all();
        $user = User::all();
        return view('peminjaman.edit', compact('peminjaman', 'barang', 'user'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $peminjaman->update($request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $barang = Barang::find($peminjaman->id_barang);
        $barang->tersedia += $peminjaman->jumlah;
        $barang->dipinjam -= $peminjaman->jumlah;
        $barang->save();

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman dihapus dan stok diperbarui.');
    }

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

    return redirect()->back()->with('success', 'Permintaan disetujui.');
}

public function decline($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->status = 'ditolak';
    $peminjaman->label_status = 'penting';
    $peminjaman->save();

    return redirect()->back()->with('success', 'Permintaan ditolak.');
}


    public function apiIndex()
{
    return response()->json(Peminjaman::with('user', 'barang')->get());
}

public function apiShow($id)
{
    $peminjaman = Peminjaman::find($id);
    if (!$peminjaman) {
        return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
    }
    return response()->json($peminjaman);
}

public function apiStore(Request $request)
{
    $peminjaman = Peminjaman::create($request->all());
    return response()->json(['message' => 'Peminjaman berhasil ditambahkan', 'data' => $peminjaman], 201);
}

public function apiUpdate(Request $request, $id)
{
    $peminjaman = Peminjaman::find($id);
    if (!$peminjaman) {
        return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
    }
    $peminjaman->update($request->all());
    return response()->json(['message' => 'Peminjaman berhasil diperbarui', 'data' => $peminjaman]);
}

public function apiDestroy($id)
{
    $peminjaman = Peminjaman::find($id);
    if (!$peminjaman) {
        return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
    }
    $peminjaman->delete();
    return response()->json(['message' => 'Peminjaman berhasil dihapus']);
}

public function apiApprove($id)
{
    $peminjaman = Peminjaman::find($id);
    if (!$peminjaman) return response()->json(['message' => 'Not found'], 404);

    $barang = Barang::find($peminjaman->id_barang);
    if ($barang->tersedia < $peminjaman->jumlah) {
        return response()->json(['message' => 'Stok tidak cukup'], 400);
    }

    $barang->tersedia -= $peminjaman->jumlah;
    $barang->dipinjam += $peminjaman->jumlah;
    $barang->save();

    $peminjaman->status = 'approved';
    $peminjaman->save();

    return response()->json(['message' => 'Approved']);
}

public function apiDecline($id)
{
    $peminjaman = Peminjaman::find($id);
    if (!$peminjaman) return response()->json(['message' => 'Not found'], 404);

    $peminjaman->status = 'declined';
    $peminjaman->save();

    return response()->json(['message' => 'Declined']);
}

}
