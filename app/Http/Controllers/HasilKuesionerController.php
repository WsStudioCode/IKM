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
}
