<?php

namespace Database\Seeders;

use App\Models\Masyarakat;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $pendidikanList = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];
        $pekerjaanList = ['Petani', 'PNS', 'Guru', 'Pelajar', 'Wiraswasta', 'Buruh'];
        $gender = ['Laki-laki', 'Perempuan'];

        for ($i = 1; $i <= 50; $i++) {
            Masyarakat::create([
                'nama' => 'Masyarakat ' . $i,
                'umur' => rand(17, 60),
                'jenis_kelamin' => $gender[array_rand($gender)],
                'pendidikan' => $pendidikanList[array_rand($pendidikanList)],
                'pekerjaan' => $pekerjaanList[array_rand($pekerjaanList)],
                'agama' => $agamaList[array_rand($agamaList)],
                'alamat' => 'Jl. Contoh No. ' . rand(1, 100) . ', Kota Contoh',
                'no_telp' => '08' . rand(1111111111, 9999999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
