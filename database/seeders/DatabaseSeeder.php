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

    }
}
