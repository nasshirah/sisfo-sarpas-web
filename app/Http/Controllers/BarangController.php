<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\kategori_barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori_barang')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = kategori_barang::all();
        return view('barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barang',
            'nama_barang' => 'required',
            'id_kategori' => 'required',
            'jumlah' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
    
        $data = $request->all();
        $data['tersedia'] = $request->jumlah;
        $data['dipinjam'] = 0;
    
        if ($request->hasFile('gambar')) {
        // Simpan ke storage/app/public/gambar_barang
        $path = $request->file('gambar')->store('gambar_barang', 'public');
        $data['gambar'] = $path; // hasilnya seperti 'gambar_barang/namafile.jpg'
    }
    
        Barang::create($data);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }
    

    public function show($id_barang)
    {
        $barang = Barang::with('kategori_barang')->findOrFail($id_barang);
        return view('barang.show', compact('barang'));
    }

    public function edit($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        $kategori = Kategori_barang::all();
        return view('barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
    
        $validated = $request->validate([
            'nama_barang' => 'required',
            'id_kategori' => 'required',
            'jumlah' => 'required|integer',
            'lokasi' => 'required',
            'status' => 'required|in:tersedia,tidak tersedia',
            'keterangan' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
    
        if ($request->hasFile('gambar')) {
        // Simpan ke storage/app/public/gambar_barang
        $path = $request->file('gambar')->store('gambar_barang', 'public');
        $validated['gambar'] = $path; // Simpan path relatifnya
    }
    
        $barang->update($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }
    

    public function destroy($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);


        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }

    public function apiIndex()
{
    return response()->json(Barang::all());
}

public function apiShow($id)
{
    $barang = Barang::find($id);
    if (!$barang) {
        return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    }
    return response()->json($barang);
}

public function apiStore(Request $request)
{
    $barang = Barang::create($request->all());
    return response()->json(['message' => 'Barang berhasil ditambahkan', 'data' => $barang], 201);
}

public function apiUpdate(Request $request, $id)
{
    $barang = Barang::find($id);
    if (!$barang) {
        return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    }
    $barang->update($request->all());
    return response()->json(['message' => 'Barang berhasil diperbarui', 'data' => $barang]);
}

public function apiDestroy($id)
{
    $barang = Barang::find($id);
    if (!$barang) {
        return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    }
    $barang->delete();
    return response()->json(['message' => 'Barang berhasil dihapus']);
}

}
