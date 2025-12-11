<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // Tambah kolom hanya jika belum ada
            if (!Schema::hasColumn('produk', 'warga_id')) {

                $table->foreignId('warga_id')
                    ->after('produk_id')
                    ->constrained('warga', 'warga_id')
                    ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (Schema::hasColumn('produk', 'warga_id')) {
                $table->dropForeign(['warga_id']);
                $table->dropColumn('warga_id');
            }
        });
    }
};
