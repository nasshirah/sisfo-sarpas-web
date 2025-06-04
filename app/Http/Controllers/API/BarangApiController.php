<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangApiController extends Controller
{
    // GET: /api/barang - Menampilkan semua barang
    public function index()
    {
        $barang = Barang::with('kategori_barang')->get()->map(function ($item) {
            $fotoUrl = null;
            if ($item->gambar) {
                $fotoPath = $item->gambar;
                if (str_starts_with($fotoPath, 'storage/')) {
                    $fotoPath = substr($fotoPath, 8);
                }
                $fotoUrl = url('storage/' . $fotoPath);
            }

            return [
                'id' => $item->id_barang,
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->nama_barang,
                'kategori' => $item->kategori_barang?->nama_kategori,
                'jumlah' => $item->jumlah,
                'tersedia' => $item->tersedia,
                'dipinjam' => $item->dipinjam,
                'kondisi' => $item->kondisi,
                'lokasi' => $item->lokasi,
                'status' => $item->status,
                'keterangan' => $item->keterangan,
                'gambar_url' => $fotoUrl,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    // GET: /api/barang/{id} - Menampilkan detail barang
    public function show($id)
    {
        $barang = Barang::with('kategori_barang')->find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $fotoUrl = null;
        if ($barang->gambar) {
            $fotoPath = $barang->gambar;
            if (str_starts_with($fotoPath, 'storage/')) {
                $fotoPath = substr($fotoPath, 8);
            }
            $fotoUrl = url('storage/' . $fotoPath);  
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $barang->id_barang,
                'kode_barang' => $barang->kode_barang, 
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori_barang?->nama_kategori,
                'jumlah' => $barang->jumlah,
                'tersedia' => $barang->tersedia,
                'dipinjam' => $barang->dipinjam,
                'kondisi' => $barang->kondisi,
                'lokasi' => $barang->lokasi,
                'status' => $barang->status,
                'keterangan' => $barang->keterangan,
                'gambar_url' => $fotoUrl,
            ]
        ]);
    }
}
