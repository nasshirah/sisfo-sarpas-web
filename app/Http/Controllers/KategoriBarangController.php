<?php

namespace App\Http\Controllers;

use App\Models\kategori_barang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategori = kategori_barang::all();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
        ]);

        kategori_barang::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(kategori_barang $kategori_barang)
    {
        return view('kategori.show', compact('kategori_barang'));
    }

    public function edit(kategori_barang $kategori_barang)
    {
        return view('kategori.edit', compact('kategori_barang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deksripsi' => 'nullable|string',
        ]);

        $kategori = kategori_barang::findOrFail($id);
        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    public function destroy(kategori_barang $kategori_barang)
    {
        $kategori_barang->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // API routes (your existing methods)
    public function apiIndex()
    {
        return response()->json(kategori_barang::all());
    }

    public function apiShow($id)
    {
        $kategori = kategori_barang::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        return response()->json($kategori);
    }

    public function apiStore(Request $request)
    {
        $kategori = kategori_barang::create($request->all());
        return response()->json(['message' => 'Kategori berhasil ditambahkan', 'data' => $kategori], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $kategori = kategori_barang::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        $kategori->update($request->all());
        return response()->json(['message' => 'Kategori berhasil diperbarui', 'data' => $kategori]);
    }

    public function apiDestroy($id)
    {
        $kategori = kategori_barang::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        $kategori->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }

}
