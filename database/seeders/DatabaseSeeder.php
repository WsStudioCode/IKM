<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // KategoriPertanyaanSeeder::class,
            // PertanyaanSeeder::class,
            // MasyarakatSeeder::class,
            // HasilKuesionerSeeder::class
            MasyarakatSeeder::class,
            PengaduanSeeder::class,
            TindakLanjutSeeder::class,
            KomentarSeeder::class,
        ]);
    }
}
