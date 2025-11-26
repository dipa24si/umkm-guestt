<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk'; // nama tabel kamu
    protected $primaryKey = 'produk_id'; // sesuaikan dengan DB

    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'deskripsi'
    ];

    public $timestamps = true;

    // Relasi ke ulasan
    public function ulasan()
    {
        return $this->hasMany(UlasanProduk::class, 'produk_id');
    }
}
