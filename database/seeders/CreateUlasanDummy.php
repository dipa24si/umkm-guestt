<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateUlasanDummy extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Ambil semua produk_id & warga_id agar sesuai FK
        $produkIds = DB::table('produk')->pluck('produk_id')->toArray();
        $wargaIds  = DB::table('warga')->pluck('warga_id')->toArray();

        // Jika salah satu kosong → hentikan agar tidak error
        if (empty($produkIds) || empty($wargaIds)) {
            dd("ISI dulu tabel produk & warga sebelum membuat ulasan dummy!");
        }

        foreach (range(1, 50) as $i) {
            DB::table('ulasan')->insert([
                'produk_id' => $faker->randomElement($produkIds),
                'warga_id'  => $faker->randomElement($wargaIds),
                'rating'    => $faker->numberBetween(1, 5),
                'komentar'  => $faker->sentence(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
