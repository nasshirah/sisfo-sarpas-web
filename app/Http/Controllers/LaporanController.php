<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month if no date range specified
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Laporan Barang
        $barangReport = Barang::with('kategori_barang')
            ->select('barang.*', 
                DB::raw('(SELECT COUNT(*) FROM peminjaman WHERE peminjaman.id_barang = barang.id_barang) as total_dipinjam')
            )
            ->get();

        // Laporan Peminjaman
        $peminjamanReport = Peminjaman::with(['user', 'barang'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->get();

        // Laporan Pengembalian
        $pengembalianReport = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])
            ->whereBetween('tanggal_kembali', [$startDate, $endDate])
            ->get();

        // Statistik Ringkasan
        $statistik = [
            'total_barang' => Barang::count(),
            'total_barang_tersedia' => Barang::sum('tersedia'),
            'total_barang_dipinjam' => Barang::sum('dipinjam'),
            'total_peminjaman' => Peminjaman::whereBetween('tanggal_pinjam', [$startDate, $endDate])->count(),
            'total_pengembalian' => Pengembalian::whereBetween('tanggal_kembali', [$startDate, $endDate])->count(),
        ];

        return view('laporan.index', [
            'barangReport' => $barangReport,
            'peminjamanReport' => $peminjamanReport,
            'pengembalianReport' => $pengembalianReport,
            'statistik' => $statistik,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}