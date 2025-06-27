<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'id_kategori',
        'jumlah',
        'tersedia',
        'dipinjam',
        'kondisi',
        'status',
        'keterangan',
        'gambar',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tersedia' => 'integer',
        'dipinjam' => 'integer'
    ];

    public function kategori_barang()
    {
        return $this->belongsTo(kategori_barang::class, 'id_kategori', 'id_kategori');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_barang', 'id_barang');
    }

    public function getGambarUrlAttribute()
    {

        return asset('images/barang/'.$this->gambar);
    }
  
}
