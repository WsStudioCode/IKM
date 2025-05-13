<?php

namespace App\Exports;

use App\Models\HasilKuesioner;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HasilKuesionerExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $periode;
    protected $tahun;

    public function __construct($periode, $tahun)
    {
        $this->periode = $periode;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = HasilKuesioner::with('masyarakat')->whereYear('tanggal_isi', $this->tahun);

        if ($this->periode == 3) {
            $query->where('tanggal_isi', '>=', Carbon::now()->subMonths(3)->startOfMonth());
        } elseif ($this->periode == 6) {
            $query->where('tanggal_isi', '>=', Carbon::now()->subMonths(6)->startOfMonth());
        }

        return $query->get()->map(function ($item, $i) {
            return [
                'No' => $i + 1,
                'Nama Masyarakat' => $item->masyarakat->nama ?? '-',
                'Nilai Rata-Rata' => $item->nilai_rata_rata,
                'Kategori Hasil' => $item->kategori_hasil,
                'Tanggal Isi' => Carbon::parse($item->tanggal_isi)->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Masyarakat', 'Nilai Rata-Rata', 'Kategori Hasil', 'Tanggal Isi'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFEEEEEE']
                ],
                'borders' => [
                    'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $title = "Hasil Kuesioner - {$this->periode} Bulan Tahun {$this->tahun}";
                $event->sheet->setCellValue('A1', $title);

                $event->sheet->mergeCells('A1:E1');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
