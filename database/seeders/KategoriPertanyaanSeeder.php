<?php

namespace Database\Seeders;

use App\Models\KategoriPertanyaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriPertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            'Persyaratan Pelayanan',
            'Prosedur Pelayanan',
            'Waktu Penyelesaian',
            'Biaya/Tarif',
            'Produk Layanan',
            'Kompetensi Pelaksana',
            'Perilaku Pelaksana',
            'Sarana dan Prasarana',
            'Penanganan Pengaduan',
            'Kesesuaian Pelayanan',
        ];

        foreach ($kategori as $nama) {
            KategoriPertanyaan::create([
                'nama' => $nama
            ]);
        }
    }
}
