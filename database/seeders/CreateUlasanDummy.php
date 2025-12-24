<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateUlasanDummy extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $produkIds = DB::table('produk')->pluck('produk_id')->toArray();
        $wargaIds  = DB::table('warga')->pluck('warga_id')->toArray();

        if (empty($produkIds) || empty($wargaIds)) {
            dd("ISI dulu tabel produk & warga sebelum membuat ulasan dummy!");
        }

        // 👉 KALIMAT ULASAN BAHASA INDONESIA
        $komentarIndonesia = [
            'Produk sangat bagus dan sesuai dengan deskripsi.',
            'Kualitas produk memuaskan, pengiriman cepat.',
            'Harga terjangkau dan rasanya enak.',
            'Produk lokal yang sangat direkomendasikan.',
            'Pelayanan ramah dan produk berkualitas.',
            'Kemasan rapi dan aman sampai tujuan.',
            'Saya puas dengan produk ini.',
            'Rasanya enak dan cocok untuk keluarga.',
            'Barang sesuai ekspektasi, akan beli lagi.',
            'Produk UMKM yang patut didukung.'
        ];

        foreach (range(1, 100) as $i) {
            DB::table('ulasan')->insert([
                'produk_id' => $faker->randomElement($produkIds),
                'warga_id'  => $faker->randomElement($wargaIds),
                'rating'    => $faker->numberBetween(1, 5),
                'komentar'  => $faker->randomElement($komentarIndonesia),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
