<?php

namespace App\Http\Controllers;

use App\Exports\ArrayExport;
use App\Models\Masyarakat;
use App\Models\Pertanyaan;
use App\Models\KategoriPertanyaan;
use App\Models\HasilKuesioner;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
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

        $query = Pengaduan::with(['masyarakat', 'tindakLanjut'])->withCount('komentar');

        if ($request->filled('q')) {
            $query->where('isi', 'like', '%' . $request->input('q') . '%');
        }

        $pengaduan = $query->latest()->paginate(5);

        $pelaporTerbaru = Pengaduan::with('masyarakat')
            ->latest()
            ->take(8)
            ->get()
            ->pluck('masyarakat')
            ->unique('id')
            ->values();

        $laporanSukses = Pengaduan::where('status', 'Selesai')
            ->latest()
            ->take(5)
            ->get();

        $kuesioner = HasilKuesioner::with('masyarakat')->get();

        $nilaiIKM = round($kuesioner->avg('nilai_rata_rata'), 2);
        $jumlahResponden = $kuesioner->count();
        $pria = $kuesioner->where('masyarakat.jenis_kelamin', 'Laki-laki')->count();
        $wanita = $kuesioner->where('masyarakat.jenis_kelamin', 'Perempuan')->count();

        $pendidikan = [
            'SMA_SMK' => $kuesioner->filter(fn($k) => str_contains($k->masyarakat->pendidikan->value ?? '', 'SMA'))->count(),
            'D1-D3' => $kuesioner->filter(fn($k) => in_array($k->masyarakat->pendidikan->value ?? '', ['D1', 'D2', 'D3']))->count(),
            'D4-S1' => $kuesioner->filter(fn($k) => in_array($k->masyarakat->pendidikan->value ?? '', ['D4', 'S1']))->count(),
            'S2-S3' => $kuesioner->filter(fn($k) => in_array($k->masyarakat->pendidikan->value ?? '', ['S2', 'S3']))->count(),
        ];

        $periode = [
            'awal' => optional($kuesioner->min('tanggal_isi'))->format('d M Y'),
            'akhir' => optional($kuesioner->max('tanggal_isi'))->format('d M Y'),
        ];

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
            'pengaduan' => $pengaduan,
            'pelaporTerbaru' => $pelaporTerbaru,
            'laporanSukses' => $laporanSukses,
            'nilaiIKM' => $nilaiIKM,
            'jumlahResponden' => $jumlahResponden,
            'pria' => $pria,
            'wanita' => $wanita,
            'pendidikan' => $pendidikan,
            'periode' => $periode,
        ]);
    }
}
