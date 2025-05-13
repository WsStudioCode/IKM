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
        $data = [
            [
                'nama' => 'Ahmad Sulaiman',
                'umur' => 35,
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S1',
                'pekerjaan' => 'PNS',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'no_telp' => '081234567891',
            ],
            [
                'nama' => 'Maria Natalia',
                'umur' => 29,
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'S2',
                'pekerjaan' => 'Guru',
                'agama' => 'Katolik',
                'alamat' => 'Jl. Anggrek No. 21, Surabaya',
                'no_telp' => '082233445566',
            ],
            [
                'nama' => 'Made Suartika',
                'umur' => 42,
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'SMA/SMK',
                'pekerjaan' => 'Petani',
                'agama' => 'Hindu',
                'alamat' => 'Jl. Raya Ubud No. 5, Gianyar',
                'no_telp' => '081112223334',
            ],
            [
                'nama' => 'Siti Rohmah',
                'umur' => 38,
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'D3',
                'pekerjaan' => 'Wiraswasta',
                'agama' => 'Islam',
                'alamat' => 'Jl. Melati No. 3, Bandung',
                'no_telp' => '083344556677',
            ],
            [
                'nama' => 'Yusuf Abdullah',
                'umur' => 45,
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'SMA/SMK',
                'pekerjaan' => 'Buruh',
                'agama' => 'Islam',
                'alamat' => 'Jl. Mangga Besar No. 8, Bekasi',
                'no_telp' => '081355667788',
            ],
            [
                'nama' => 'Agnes Monica',
                'umur' => 31,
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Pelajar',
                'agama' => 'Kristen',
                'alamat' => 'Jl. Mawar No. 2, Medan',
                'no_telp' => '082144556677',
            ],
            [
                'nama' => 'Budi Santoso',
                'umur' => 50,
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2',
                'pekerjaan' => 'PNS',
                'agama' => 'Islam',
                'alamat' => 'Jl. Sudirman No. 18, Semarang',
                'no_telp' => '081266778899',
            ],
            [
                'nama' => 'Linda Oktaviani',
                'umur' => 27,
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'D3',
                'pekerjaan' => 'Wiraswasta',
                'agama' => 'Buddha',
                'alamat' => 'Jl. Kenanga No. 14, Denpasar',
                'no_telp' => '083366778899',
            ],
            [
                'nama' => 'Antonius Setiawan',
                'umur' => 33,
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Guru',
                'agama' => 'Kristen',
                'alamat' => 'Jl. Gajah Mada No. 7, Yogyakarta',
                'no_telp' => '082288990011',
            ],
            [
                'nama' => 'Dewi Kurniasari',
                'umur' => 40,
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'SMP',
                'pekerjaan' => 'Buruh',
                'agama' => 'Islam',
                'alamat' => 'Jl. Cempaka No. 20, Palembang',
                'no_telp' => '081399887766',
            ],
        ];

        foreach ($data as $item) {
            Masyarakat::create(array_merge($item, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
