<?php

namespace Database\Seeders;

use App\Models\Warga;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FotoWargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $fotoDummy = [
            'warga/dummy1.jpg',
            'warga/dummy2.jpg',
            'warga/dummy3.jpg',
            'warga/dummy4.jpg',
            'warga/dummy5.jpg',
        ];

        foreach (range(1, 100) as $i) {
            Warga::create([
                'no_ktp'        => $faker->unique()->numerify('################'),
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => 'Islam',
                'pekerjaan'     => $faker->jobTitle,
                'telp'          => $faker->phoneNumber,
                'email'         => $faker->safeEmail,
                'foto'          => $faker->randomElement($fotoDummy),
            ]);
        }
    }
}
