<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanProduk extends Model
{
    use HasFactory;

    protected $table      = 'ulasan';
    protected $primaryKey = 'ulasan_id';
    public $timestamps    = true;

    protected $fillable = [
        'produk_id',
        'warga_id',
        'rating',
        'komentar',
    ];

    // Relasi ke Produk (opsional)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // Relasi ke Warga / User (opsional)
    public function warga()
    {
        return $this->belongsTo(User::class, 'warga_id');
    }

    public function medias()
    {
        return $this->hasMany(\App\Models\Media::class, 'ref_id', 'ulasan_id')
            ->where('ref_table', 'ulasan_produk')
            ->orderBy('sort_order');
    }

}
