<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProdukDummy extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // ambil semua warga_id sebagai pemilik produk
        $wargaIds = DB::table('warga')->pluck('warga_id')->toArray();

        if (empty($wargaIds)) {
            dd("ISI dulu tabel warga sebelum membuat produk dummy!");
        }

        foreach (range(1, 30) as $i) {
            DB::table('produk')->insert([
                'warga_id'    => $faker->randomElement($wargaIds),
                'nama_produk' => $faker->randomElement([
                    'Kopi Arabika UMKM',
                    'Keripik Singkong Pedas',
                    'Kue Kering Homemade',
                    'Sambal Rumahan',
                    'Kerajinan Kayu',
                    'Baju Batik Lokal',
                    'Roti Rumahan',
                ]),
                'deskripsi'   => $faker->sentence(10),
                'harga'       => $faker->numberBetween(10000, 150000),
                'stok'        => $faker->numberBetween(5, 100),
                'status'      => 'aktif',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
