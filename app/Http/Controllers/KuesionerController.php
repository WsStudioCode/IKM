<?php

namespace App\Http\Controllers;

use App\Models\HasilKuesioner;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use App\Models\JawabanKuesioner;

class KuesionerController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('masyarakat_id')) {
            return redirect()->route('masyarakat.form');
        }

        $page = $request->get('page', 1);
        $limit = 10;

        $pertanyaan = Pertanyaan::where('aktif', 1)
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        $total = Pertanyaan::where('aktif', 1)->count();
        $totalPages = ceil($total / $limit);

        return view('responden.kuesioner', compact('pertanyaan', 'page', 'totalPages'));
    }


    // public function submit(Request $request)
    // {
    //     $data = $request->validate([
    //         'jawaban' => 'required|array',
    //         'jawaban.*' => 'required|integer|min:1|max:4',
    //     ]);

    //     $nilai = array_values($data['jawaban']);
    //     $rataMentah = array_sum($nilai) / count($nilai);

    //     $rata = (($rataMentah - 1) / 3) * 75 + 25;

    //     if ($rata >= 88.31) {
    //         $kategori = 'Sangat Sesuai';
    //     } elseif ($rata >= 78.61) {
    //         $kategori = 'Sesuai';
    //     } elseif ($rata >= 65.00) {
    //         $kategori = 'Kurang Sesuai';
    //     } else {
    //         $kategori = 'Tidak Sesuai';
    //     }

    //     HasilKuesioner::create([
    //         'masyarakat_id' => session('masyarakat_id'),
    //         'nilai_rata_rata' => round($rata, 2),
    //         'kategori_hasil' => $kategori,
    //         'tanggal_isi' => now(),
    //     ]);

    //     return redirect()->route('responden.masyarakat')->with('success', 'Kuesioner berhasil dikirim!');
    // }

   public function submit(Request $request)
{
    $data = $request->validate([
        'jawaban' => 'required|array',
        'jawaban.*' => 'required|integer|min:1|max:4',
    ]);

    $masyarakatId = session('masyarakat_id');
    $tanggalIsi = now();

    $nilai = array_values($data['jawaban']);
    $rataMentah = array_sum($nilai) / count($nilai);
    $rata = (($rataMentah - 1) / 3) * 75 + 25;

    $kategori = match (true) {
        $rata >= 88.31 => 'Sangat Sesuai',
        $rata >= 78.61 => 'Sesuai',
        $rata >= 65.00 => 'Kurang Sesuai',
        default        => 'Tidak Sesuai',
    };

    // ⬇️ Simpan dulu ke tabel hasil_kuesioner dan ambil ID-nya
    $hasil = HasilKuesioner::create([
        'masyarakat_id' => $masyarakatId,
        'nilai_rata_rata' => round($rata, 2),
        'kategori_hasil' => $kategori,
        'tanggal_isi' => $tanggalIsi,
    ]);

    // ⬇️ Simpan semua jawaban dan kaitkan dengan hasil_kuesioner_id
    foreach ($data['jawaban'] as $pertanyaanId => $jawaban) {
        JawabanKuesioner::create([
            'masyarakat_id' => $masyarakatId,
            'pertanyaan_id' => $pertanyaanId,
            'jawaban' => $jawaban,
            'tanggal_isi' => $tanggalIsi,
            'hasil_kuesioner_id' => $hasil->id, // ⬅️ penting!
        ]);
    }

    return redirect()->route('responden.masyarakat')->with('success', 'Kuesioner berhasil dikirim!');
}

}
