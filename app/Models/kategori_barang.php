<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori_barang extends Model
{
    use HasFactory;
    protected $table = 'kategori_barang';
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori', 'deksripsi'];

    public function barang() {
        return $this->hasMany(Barang::class, 'id_kategori');
    }
}
