<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\kategori_barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah data untuk tampilan dashboard
        $totalBarang = Barang::count();
        $totalKategori = kategori_barang::count();
        $totalPeminjaman = Peminjaman::count();
        $totalPengembalian = Pengembalian::count();
        $totalUser = User::count();
        
        // Barang yang sering dipinjam (5 teratas)
        $barangPopuler = Barang::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->take(5)
            ->get();
            
        // Peminjaman terbaru
        $peminjamanTerbaru = Peminjaman::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // status peminjaman
        $statusPeminjaman = [
            'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'dikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
            'terlambat' => Peminjaman::where('status', 'terlambat')->count(),
        ];
        
        //  kategori barang
        $kategoriStats = kategori_barang::withCount('barang')
            ->orderBy('barang_count', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalBarang', 
            'totalKategori', 
            'totalPeminjaman', 
            'totalPengembalian',
            'totalUser',
            'barangPopuler',
            'peminjamanTerbaru',
            'statusPeminjaman',
            'kategoriStats'
        ));
    }
}