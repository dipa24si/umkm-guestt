<?php
namespace App\Models;

use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Scope filter
    public function scopeFilter($query, $request, array $filterableColumns)
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->$column);
            }
        }

        return $query;
    }
     // Scope search
     public function scopeSearch($query, ?string $search, array $searchableColumns)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search, $searchableColumns) {
            foreach ($searchableColumns as $column) {
                $q->orWhere($column, 'LIKE', "%{$search}%");
            }
        });
    }
}

