<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateWargaDummy extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        foreach (range(1, 100) as $index) {
            DB::table('warga')->insert([
                'no_ktp'        => $faker->unique()->numerify('################'),
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan'     => $faker->jobTitle,
                'telp'          => $faker->phoneNumber,
                'email'         => $faker->optional()->safeEmail,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
