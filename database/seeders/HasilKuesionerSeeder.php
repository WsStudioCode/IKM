<?php

namespace Database\Seeders;

use App\Models\HasilKuesioner;
use App\Models\Masyarakat;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HasilKuesionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = function ($nilai) {
            if ($nilai >= 3.51) return 'Sangat Sesuai';
            if ($nilai >= 3.01) return 'Sesuai';
            if ($nilai >= 2.51) return 'Kurang Sesuai';
            return 'Tidak Sesuai';
        };


        $masyarakats = Masyarakat::inRandomOrder()->limit(30)->get();

        foreach ($masyarakats as $masyarakat) {
            $nilai = round(mt_rand(100, 400) / 100, 2);
            HasilKuesioner::create([
                'masyarakat_id' => $masyarakat->id,
                'nilai_rata_rata' => $nilai,
                'kategori_hasil' => $kategori($nilai),
                'tanggal_isi' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
