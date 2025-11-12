<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->increments('ulasan_id'); // Primary key auto increment
            $table->integer('produk_id'); // ID produk
            $table->integer('warga_id')->nullable(); // ID warga
            $table->integer('rating')->comment('1-5 bintang'); // Nilai rating
            $table->text('komentar')->nullable(); // Isi komentar
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
