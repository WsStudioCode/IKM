<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\TindakLanjut;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TindakLanjutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengaduan = Pengaduan::inRandomOrder()->take(5)->get();

        foreach ($pengaduan as $p) {
            TindakLanjut::create([
                'pengaduan_id' => $p->id,
                'tanggapan' => 'Terima kasih atas masukannya, akan kami tindak lanjuti.',
                'tanggal_tindak_lanjut' => Carbon::now()->subDays(rand(1, 10)),
            ]);

            $p->update(['status' => 'Diproses']);
        }
    }
}
