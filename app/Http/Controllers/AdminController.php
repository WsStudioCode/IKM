<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\Pertanyaan;
use App\Models\KategoriPertanyaan;
use App\Models\HasilKuesioner;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Ambil tahun dari query masing-masing grafik
        $tahunPengaduan = $request->input('tahun_pengaduan', now()->year);
        $tahunKepuasan = $request->input('tahun_kepuasan', now()->year);

        // Range tahun untuk dropdown
        $tahunRange = range(2020, now()->year);

        // Statistik umum
        $totalMasyarakat = Masyarakat::count();
        $totalPertanyaan = Pertanyaan::count();
        $totalKategori = KategoriPertanyaan::count();

        // Statistik pengaduan
        $jumlahPengaduan = Pengaduan::whereYear('created_at', $tahunPengaduan)->count();
        $jumlahMenunggu = Pengaduan::whereYear('created_at', $tahunPengaduan)->where('status', 'menunggu')->count();
        $jumlahDiproses = Pengaduan::whereYear('created_at', $tahunPengaduan)->where('status', 'diproses')->count();
        $jumlahSelesai = Pengaduan::whereYear('created_at', $tahunPengaduan)->where('status', 'selesai')->count();

        // Grafik Pengaduan Bulanan
        $pengaduanBulanan = Pengaduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahunPengaduan)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan')
            ->all();

        $grafikPengaduan = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikPengaduan[] = $pengaduanBulanan[$i] ?? 0;
        }

        // Grafik Kepuasan Bulanan
        $grafikData = HasilKuesioner::selectRaw('MONTH(tanggal_isi) as bulan, kategori_hasil, COUNT(*) as jumlah')
            ->whereYear('tanggal_isi', $tahunKepuasan)
            ->groupBy('bulan', 'kategori_hasil')
            ->get();

        $kategoriList = ['Sangat Sesuai', 'Sesuai', 'Kurang Sesuai', 'Tidak Sesuai'];
        $grafik = [];

        foreach ($kategoriList as $kategori) {
            $grafik[$kategori] = array_fill(1, 12, 0);
        }

        foreach ($grafikData as $item) {
            $grafik[$item->kategori_hasil][$item->bulan] = $item->jumlah;
        }

        $bulanLabels = collect(range(1, 12))->map(fn($m) => date('F', mktime(0, 0, 0, $m, 10)));

        // Data Kuesioner
        $hasilKuesioner = HasilKuesioner::with('masyarakat')
            ->whereYear('tanggal_isi', $tahunKepuasan)
            ->latest('tanggal_isi')
            ->paginate(10);

        return view('dashboard', [
            'totalMasyarakat' => $totalMasyarakat,
            'totalPertanyaan' => $totalPertanyaan,
            'totalKategori' => $totalKategori,
            'listTahun' => $tahunRange,
            'tahunPengaduan' => $tahunPengaduan,
            'tahunKepuasan' => $tahunKepuasan,
            'hasilKuesioner' => $hasilKuesioner,
            'grafik' => [
                'bulan' => $bulanLabels,
                'Sangat Sesuai' => array_values($grafik['Sangat Sesuai']),
                'Sesuai' => array_values($grafik['Sesuai']),
                'Kurang Sesuai' => array_values($grafik['Kurang Sesuai']),
                'Tidak Sesuai' => array_values($grafik['Tidak Sesuai']),
            ],
            'jumlahPengaduan' => $jumlahPengaduan,
            'jumlahMenunggu' => $jumlahMenunggu,
            'jumlahDiproses' => $jumlahDiproses,
            'jumlahSelesai' => $jumlahSelesai,
            'grafikPengaduan' => $grafikPengaduan,
        ]);
    }
}
