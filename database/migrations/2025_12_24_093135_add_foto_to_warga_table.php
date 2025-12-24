<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoToWargaTable extends Migration
{
    public function up(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
}
