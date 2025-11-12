<?php

namespace App\Models;

use App\Models\Warga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warga extends Model
{
        use HasFactory;

    // Nama tabel di database
    protected $table = 'warga';

    // Primary key
    protected $primaryKey = 'warga_id';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];

    // Jika tidak ingin pakai timestamps (created_at & updated_at)
    public $timestamps = false;

}
