<?php

namespace Database\Seeders;

use App\Models\Pertanyaan;
use App\Models\KategoriPertanyaan;
use Illuminate\Database\Seeder;

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaan = [
            [
                'isi_pertanyaan' => 'Bagaimana pendapat Anda tentang kemudahan prosedur layanan?',
                'kategori_nama' => 'Prosedur Pelayanan',
            ],
            [
                'isi_pertanyaan' => 'Bagaimana pendapat Anda tentang kecepatan layanan?',
                'kategori_nama' => 'Waktu Penyelesaian',
            ],
            [
                'isi_pertanyaan' => 'Bagaimana pendapat Anda tentang sikap petugas?',
                'kategori_nama' => 'Perilaku Pelaksana',
            ],
        ];

        foreach ($pertanyaan as $p) {
            $kategori = KategoriPertanyaan::where('nama', $p['kategori_nama'])->first();
            Pertanyaan::create([
                'isi_pertanyaan' => $p['isi_pertanyaan'],
                'kategori_id' => $kategori?->id,
                'aktif' => true,
            ]);
        }
    }
}
