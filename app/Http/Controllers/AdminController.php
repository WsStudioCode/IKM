<?php

namespace App\Http\Controllers;

use App\Exports\ArrayExport;
use App\Models\Masyarakat;
use App\Models\Pertanyaan;
use App\Models\KategoriPertanyaan;
use App\Models\HasilKuesioner;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $tahunPengaduan = $request->input('tahun_pengaduan', now()->year);
        $tahunKepuasan = $request->input('tahun_kepuasan', now()->year);
        $periodeKepuasan = $request->input('periode_kepuasan', '12');

        $tahunRange = range(2020, now()->year);

        // Statistik
        $totalMasyarakat = Masyarakat::count();
        $totalPertanyaan = Pertanyaan::count();
        $totalKategori = KategoriPertanyaan::count();
        $jumlahPengaduan = Pengaduan::whereYear('created_at', $tahunPengaduan)->count();
        $jumlahMenunggu = Pengaduan::whereYear('created_at', $tahunPengaduan)->where('status', 'menunggu')->count();
        $jumlahDiproses = Pengaduan::whereYear('created_at', $tahunPengaduan)->where('status', 'diproses')->count();
        $jumlahSelesai = Pengaduan::whereYear('created_at', $tahunPengaduan)->where('status', 'selesai')->count();

        // Grafik Pengaduan
        $pengaduanBulanan = Pengaduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahunPengaduan)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan')
            ->all();

        $grafikPengaduan = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikPengaduan[] = $pengaduanBulanan[$i] ?? 0;
        }

        // Grafik Kepuasan
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

        // Filter Kuesioner by Periode
        $queryKepuasan = HasilKuesioner::with('masyarakat')
            ->whereYear('tanggal_isi', $tahunKepuasan);

        if ($periodeKepuasan == '3') {
            $queryKepuasan->where('tanggal_isi', '>=', now()->subMonths(3));
        } elseif ($periodeKepuasan == '6') {
            $queryKepuasan->where('tanggal_isi', '>=', now()->subMonths(6));
        }

        $hasilKuesioner = $queryKepuasan->latest('tanggal_isi')->paginate(10);

        return view('dashboard', [
            'totalMasyarakat' => $totalMasyarakat,
            'totalPertanyaan' => $totalPertanyaan,
            'totalKategori' => $totalKategori,
            'listTahun' => $tahunRange,
            'tahunPengaduan' => $tahunPengaduan,
            'tahunKepuasan' => $tahunKepuasan,
            'periodeKepuasan' => $periodeKepuasan,
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

    // public function exportKepuasan(Request $request)
    // {
    //     $tahun = $request->input('tahun', now()->year);
    //     $periode = $request->input('periode', 12);

    //     $query = HasilKuesioner::select('tanggal_isi', 'kategori_hasil', 'masyarakat_id')
    //         ->whereYear('tanggal_isi', $tahun);

    //     if ($periode == 3) {
    //         $query->where('tanggal_isi', '>=', now()->subMonths(3));
    //     } elseif ($periode == 6) {
    //         $query->where('tanggal_isi', '>=', now()->subMonths(6));
    //     }

    //     $data = $query->get()->map(function ($item) {
    //         return [
    //             'Tanggal' => $item->tanggal_isi->format('d-m-Y'),
    //             'Kategori Hasil' => $item->kategori_hasil,
    //             'Masyarakat ID' => $item->masyarakat_id,
    //         ];
    //     });

    //     $filename = 'rekap_kepuasan_' . $periode . '_bulan.xlsx';
    //     return Excel::download(new ArrayExport($data->toArray()), $filename);
    // }
}
