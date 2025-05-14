<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class PengaduanExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $tahun;
    protected $search;

    public function __construct($tahun, $search = null)
    {
        $this->tahun = $tahun;
        $this->search = $search;
    }

    public function collection(): Collection
    {
        $query = Pengaduan::with('masyarakat')
            ->whereYear('created_at', $this->tahun);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('status', 'like', "%{$this->search}%")
                    ->orWhereHas('masyarakat', function ($sub) {
                        $sub->where('nama', 'like', "%{$this->search}%");
                    });
            });
        }

        $data = $query->get();

        return $data->map(function ($item, $i) {
            return [
                'No' => $i + 1,
                'Nama Masyarakat' => $item->masyarakat->nama ?? '-',
                'Isi Pengaduan' => $item->isi,
                'Status' => ucfirst($item->status),
                'Tanggal Dibuat' => Carbon::parse($item->created_at)->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Masyarakat', 'Isi Pengaduan', 'Status', 'Tanggal Dibuat'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFEFEFEF'],
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
                $title = "Laporan Pengaduan Tahun {$this->tahun}";
                $event->sheet->setCellValue('A1', $title);
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
