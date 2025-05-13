<?php

namespace Database\Seeders;

use App\Models\HasilKuesioner;
use App\Models\Masyarakat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HasilKuesionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakats = Masyarakat::inRandomOrder()->limit(30)->get();

        foreach ($masyarakats as $masyarakat) {
            // Simulasikan jawaban 10 pertanyaan, nilai 1–4
            $jawaban = [];
            for ($i = 0; $i < 10; $i++) {
                $jawaban[] = rand(1, 4);
            }

            $rataMentah = array_sum($jawaban) / count($jawaban);
            $rata = (($rataMentah - 1) / 3) * 75 + 25;
            $kategori = $this->konversiKategori($rata);

            HasilKuesioner::create([
                'masyarakat_id' => $masyarakat->id,
                'nilai_rata_rata' => round($rata, 2),
                'kategori_hasil' => $kategori,
                'tanggal_isi' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }

    private function konversiKategori($rata): string
    {
        if ($rata >= 88.31) {
            return 'Sangat Sesuai';
        } elseif ($rata >= 78.61) {
            return 'Sesuai';
        } elseif ($rata >= 65.00) {
            return 'Kurang Sesuai';
        } else {
            return 'Tidak Sesuai';
        }
    }
}
