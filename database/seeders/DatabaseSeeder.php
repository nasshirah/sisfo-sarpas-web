<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\kategori_barang;
use App\Models\Barang;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa kategori (menggunakan updateOrCreate untuk menghindari duplikasi)
        $kategoriElektronik = kategori_barang::updateOrCreate(
            ['nama_kategori' => 'Elektronik'],
            ['deksripsi' => 'Barang-barang elektronik']
        );

        $kategoriAlatTulis = kategori_barang::updateOrCreate(
            ['nama_kategori' => 'Alat Tulis'],
            ['deksripsi' => 'Barang-barang alat tulis']
        );

        $kategoriFurniture = kategori_barang::updateOrCreate(
            ['nama_kategori' => 'Furniture'],
            ['deksripsi' => 'Barang-barang mebel dan furniture']
        );

        // Buat user admin dan pengguna biasa (menggunakan updateOrCreate)
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $userGhina = User::updateOrCreate(
            ['email' => 'ghina@gmail.com'],
            [
                'name' => 'ghina',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        $userSyifa = User::updateOrCreate(
            ['email' => 'syifa@gmail.com'],
            [
                'name' => 'syifa',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Buat barang dengan field lengkap (menggunakan updateOrCreate berdasarkan kode_barang)
        $barang1 = Barang::updateOrCreate(
            ['kode_barang' => 'BRG001'],
            [
                'nama_barang' => 'Laptop ASUS ROG',
                'id_kategori' => $kategoriElektronik->id_kategori,
                'jumlah' => 10,
                'tersedia' => 8,
                'dipinjam' => 2,
                'kondisi' => 'Baik',
                'lokasi' => 'Lab Komputer A1',
                'status' => 'tersedia',
                'keterangan' => 'Laptop gaming untuk desain grafis',
            ]
        );

        $barang2 = Barang::updateOrCreate(
            ['kode_barang' => 'BRG002'],
            [
                'nama_barang' => 'Printer Canon MX497',
                'id_kategori' => $kategoriElektronik->id_kategori,
                'jumlah' => 5,
                'tersedia' => 0,
                'dipinjam' => 5,
                'kondisi' => 'Rusak Ringan',
                'lokasi' => 'Gudang Peralatan',
                'status' => 'tidak tersedia',
                'keterangan' => 'Printer warna, perlu penggantian tinta',
            ]
        );

        $barang3 = Barang::updateOrCreate(
            ['kode_barang' => 'BRG003'],
            [
                'nama_barang' => 'Meja Kerja Kayu',
                'id_kategori' => $kategoriFurniture->id_kategori,
                'jumlah' => 8,
                'tersedia' => 6,
                'dipinjam' => 2,
                'kondisi' => 'Baik',
                'lokasi' => 'Lab Multimedia',
                'status' => 'tersedia',
                'keterangan' => 'Meja kerja dengan laci penyimpanan',
            ]
        );

        $barang4 = Barang::updateOrCreate(
            ['kode_barang' => 'BRG004'],
            [
                'nama_barang' => 'Pulpen Pilot',
                'id_kategori' => $kategoriAlatTulis->id_kategori,
                'jumlah' => 50,
                'tersedia' => 45,
                'dipinjam' => 5,
                'kondisi' => 'Baik',
                'lokasi' => 'Gudang Alat Tulis',
                'status' => 'tersedia',
                'keterangan' => 'Pulpen tinta hitam, 0.5mm',
            ]
        );

        // Buat peminjaman (hanya jika belum ada)
        $peminjaman1 = Peminjaman::firstOrCreate([
            'id_user' => $userGhina->id,
            'id_barang' => $barang1->id_barang,
            'tanggal_pinjam' => now()->subDays(3)->format('Y-m-d'),
        ], [
            'jumlah' => 1,
            'status' => 'Diminta',
            'tanggal_kembali' => now()->addDays(7),
            'label_status' => 'Menunggu',
        ]);

        $peminjaman2 = Peminjaman::firstOrCreate([
            'id_user' => $userGhina->id,
            'id_barang' => $barang3->id_barang,
            'tanggal_pinjam' => now()->subDays(10)->format('Y-m-d'),
        ], [
            'jumlah' => 2,
            'status' => 'diKembalikan',
            'tanggal_kembali' => now()->subDays(2),
            'label_status' => 'Selesai',
        ]);

        // Buat pengembalian (hanya jika peminjaman ada dan belum ada pengembalian)
        if ($peminjaman1->exists) {
            Pengembalian::firstOrCreate([
                'id_peminjaman' => $peminjaman1->id,
            ], [
                'tanggal_kembali' => now()->subDays(2),
                'keterangan' => 'Baik, tidak ada kerusakan',
                'label_status' => 'Selesai'
            ]);
        }
    }
}