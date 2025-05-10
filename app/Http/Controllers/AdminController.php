<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\Pertanyaan;
use App\Models\KategoriPertanyaan;
use App\Models\HasilKuesioner;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $tahunDipilih = $request->input('tahun', now()->year);

        $tahunRange = range(2020, 2025);

        $totalMasyarakat = Masyarakat::count();
        $totalPertanyaan = Pertanyaan::count();
        $totalKategori = KategoriPertanyaan::count();

        $grafikData = HasilKuesioner::selectRaw('MONTH(tanggal_isi) as bulan, kategori_hasil, COUNT(*) as jumlah')
            ->whereYear('tanggal_isi', $tahunDipilih)
            ->groupBy('bulan', 'kategori_hasil')
            ->get();

        $kategoriList = ['Sangat Sesuai', 'Sesuai', 'Kurang Sesuai', 'Tidak Sesuai'];
        $grafik = [];

        foreach ($kategoriList as $kategori) {
            $grafik[$kategori] = array_fill(1, 12, 0); // bulan 1–12 default 0
        }

        foreach ($grafikData as $item) {
            $grafik[$item->kategori_hasil][$item->bulan] = $item->jumlah;
        }

        $bulanLabels = collect(range(1, 12))->map(fn($m) => date('F', mktime(0, 0, 0, $m, 10)));

        $hasilKuesioner = HasilKuesioner::with('masyarakat')
            ->whereYear('tanggal_isi', $tahunDipilih)
            ->latest('tanggal_isi')
            ->paginate(10);

        return view('dashboard', [
            'totalMasyarakat' => $totalMasyarakat,
            'totalPertanyaan' => $totalPertanyaan,
            'totalKategori' => $totalKategori,
            'listTahun' => $tahunRange,
            'hasilKuesioner' => $hasilKuesioner,
            'grafik' => [
                'bulan' => $bulanLabels,
                'Sangat Sesuai' => array_values($grafik['Sangat Sesuai']),
                'Sesuai' => array_values($grafik['Sesuai']),
                'Kurang Sesuai' => array_values($grafik['Kurang Sesuai']),
                'Tidak Sesuai' => array_values($grafik['Tidak Sesuai']),
            ]
        ]);
    }
}
