<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('produk_id'); // Primary Key
            $table->unsignedBigInteger('umkm_id'); // Foreign Key ke tabel UMKM

            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2); // harga DECIMAL
            $table->integer('stok')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();

            // foreign key
            $table->foreign('umkm_id')->references('umkm_id')->on('umkm')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
