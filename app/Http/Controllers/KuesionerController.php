<?php

namespace App\Http\Controllers;

use App\Models\HasilKuesioner;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    public function index(Request $request)
    {
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

    public function submit(Request $request)
    {
        $data = $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|integer|min:1|max:4',
        ]);

        $nilai = array_values($data['jawaban']);
        $rata = array_sum($nilai) / count($nilai);

        if ($rata < 1.75) {
            $kategori = 'Tidak Sesuai';
        } elseif ($rata < 2.51) {
            $kategori = 'Kurang Sesuai';
        } elseif ($rata < 3.26) {
            $kategori = 'Sesuai';
        } else {
            $kategori = 'Sangat Sesuai';
        }

        HasilKuesioner::create([
            'masyarakat_id' => session('masyarakat_id'),
            'nilai_rata_rata' => $rata,
            'kategori_hasil' => $kategori,
            'tanggal_isi' => now(),
        ]);

        return redirect()->route('responden.masyarakat')->with('success', 'Kuesioner berhasil dikirim!');
    }
}
