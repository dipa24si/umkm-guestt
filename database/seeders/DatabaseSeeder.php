<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CreateWargaDummy::class,
            FotoWargaSeeder::class,
            CreateProdukDummy::class,
            CreateUlasanDummy::class,
        ]);
    }
}

