<?php

namespace App\Http\Controllers;

use App\DataTables\HasilKuesionerDataTable;
use App\Exports\ArrayExport;
use App\Exports\HasilKuesionerExport;
use App\Models\HasilKuesioner;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\JawabanKuesioner;
use App\Models\Masyarakat;
use App\Models\Pertanyaan;


class HasilKuesionerController extends Controller
{
    public function index(HasilKuesionerDataTable $databtale)
    {
        return $databtale->render('admin.hasilkuesioner.index');
    }

    public function exportPDF(Request $request)
    {
        $periode = $request->get('periode', 12);
        $tahun = $request->get('tahun', now()->year);

        $query = \App\Models\HasilKuesioner::with('masyarakat')
            ->whereYear('tanggal_isi', $tahun);

        if ($periode == 3) {
            $query->where('tanggal_isi', '>=', now()->subMonths(3)->startOfMonth());
        } elseif ($periode == 6) {
            $query->where('tanggal_isi', '>=', now()->subMonths(6)->startOfMonth());
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.hasilkuesioner.export-pdf', compact('data', 'periode', 'tahun'));
        return $pdf->download('hasil_kuesioner_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $periode = $request->get('periode', 12);
        $tahun = $request->get('tahun', now()->year);
        $tanggal = Carbon::now()->format('Y-m-d');

        $filename = "Hasil_Kuesioner_{$tanggal}.xlsx";

        return Excel::download(new HasilKuesionerExport($periode, $tahun), $filename);
    }

    public function show(HasilKuesioner $hasil)
{
    $hasil->load('masyarakat');

    $jawaban = JawabanKuesioner::with('pertanyaan')
        ->where('hasil_kuesioner_id', $hasil->id)
        ->get();

    $masyarakat = $hasil->masyarakat;

    return view('admin.hasilkuesioner.detail-kuesioner', compact('hasil', 'jawaban', 'masyarakat'));
}

    // public function rekapPerPertanyaan()
    // {
    //     $rekap = \App\Models\JawabanKuesioner::selectRaw('
    //             pertanyaan_id,
    //             COUNT(*) as total_responden,
    //             SUM(jawaban) as total_skor,
    //             ROUND(AVG(jawaban), 2) as rata_rata_jawaban
    //         ')
    //         ->groupBy('pertanyaan_id')
    //         ->with('pertanyaan')
    //         ->get();

    //     // Hitung total nilai IKM = SUM(rata-rata * 0.11) * 25
    //     $totalIKM = $rekap->sum(function ($item) {
    //         return $item->rata_rata_jawaban * 0.11;
    //     });

    //     $nilaiAkhirIKM = round($totalIKM * 25, 2);

    //     return view('admin.rekapPerPertanyaan.index', compact('rekap', 'nilaiAkhirIKM'));
    // }

    public function rekapPerPertanyaan(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = \App\Models\JawabanKuesioner::selectRaw('
                pertanyaan_id,
                COUNT(*) as total_responden,
                SUM(jawaban) as total_skor,
                ROUND(AVG(jawaban), 2) as rata_rata_jawaban
            ')
            ->with('pertanyaan')
            ->groupBy('pertanyaan_id');

        // Gunakan kolom tanggal_isi untuk filter
        if ($from && $to) {
            $query->whereBetween('tanggal_isi', [$from . ' 00:00:00', $to . ' 23:59:59']);
        } elseif ($from) {
            $query->where('tanggal_isi', '>=', $from . ' 00:00:00');
        } elseif ($to) {
            $query->where('tanggal_isi', '<=', $to . ' 23:59:59');
        }

        $rekap = $query->get();

        $totalIKM = $rekap->sum(function ($item) {
            return $item->rata_rata_jawaban * 0.11;
        });

        $nilaiAkhirIKM = round($totalIKM * 25, 2);
        $keteranganMutu = '';

        if ($nilaiAkhirIKM >= 88.31) {
            $keteranganMutu = 'A (Sangat Baik)';
            $warnaMutu = 'success'; // hijau
        } elseif ($nilaiAkhirIKM >= 76.61) {
            $keteranganMutu = 'B (Baik)';
            $warnaMutu = 'primary'; // biru
        } elseif ($nilaiAkhirIKM >= 65.00) {
            $keteranganMutu = 'C (Kurang Baik)';
            $warnaMutu = 'warning'; // kuning
        } else {
            $keteranganMutu = 'D (Tidak Baik)';
            $warnaMutu = 'danger'; // merah
        }

        return view('admin.rekapPerPertanyaan.index', compact('rekap', 'nilaiAkhirIKM', 'keteranganMutu', 'warnaMutu'));
    }

}
