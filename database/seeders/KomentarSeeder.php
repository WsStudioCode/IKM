<?php

namespace Database\Seeders;

use App\Models\Komentar;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\TindakLanjut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = Masyarakat::inRandomOrder()->take(5)->get();
        $pengaduan = Pengaduan::inRandomOrder()->take(3)->get();
        $tindakLanjut = TindakLanjut::inRandomOrder()->take(3)->get();

        foreach ($pengaduan as $p) {
            Komentar::create([
                'masyarakat_id' => $masyarakat->random()->id,
                'pengaduan_id' => $p->id,
                'isi' => 'Saya juga mengalami hal serupa.',
            ]);
        }

        foreach ($tindakLanjut as $t) {
            Komentar::create([
                'masyarakat_id' => $masyarakat->random()->id,
                'tindak_lanjut_id' => $t->id,
                'isi' => 'Terima kasih sudah ditanggapi.',
            ]);
        }
    }
}
