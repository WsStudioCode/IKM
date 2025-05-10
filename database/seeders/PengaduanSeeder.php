<?php

namespace Database\Seeders;

use App\Models\Masyarakat;
use App\Models\Pengaduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = Masyarakat::inRandomOrder()->take(10)->get();

        foreach ($masyarakat as $m) {
            Pengaduan::create([
                'masyarakat_id' => $m->id,
                'isi' => 'Saya merasa pelayanan di loket X kurang cepat.',
                'status' => 'Menunggu',
            ]);
        }
    }
}
