<?php

namespace App\DataTables;

use App\Models\HasilKuesioner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class HasilKuesionerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('nama_masyarakat', function ($row) {
                return $row->masyarakat->nama ?? '-';
            })
            ->editColumn('tanggal_isi', function ($row) {
                return Carbon::parse($row->tanggal_isi)->translatedFormat('d F Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.hasilkuesioner.partials.actions', compact('row'))->render();
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(HasilKuesioner $model): QueryBuilder
    {
        $query = $model->newQuery()->with('masyarakat');

        $periode = request()->get('periode', 12);
        $tahun = request()->get('tahun', now()->year);
        $search = request()->get('search_custom');

        $query->whereYear('tanggal_isi', $tahun);

        if ($periode == 3) {
            $query->where('tanggal_isi', '>=', Carbon::now()->subMonths(3)->startOfMonth());
        } elseif ($periode == 6) {
            $query->where('tanggal_isi', '>=', Carbon::now()->subMonths(6)->startOfMonth());
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('masyarakat', fn($m) => $m->where('nama', 'like', '%' . $search . '%'))
                    ->orWhere('kategori_hasil', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    /**
     * Configure the DataTable HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('hasilkuesioner-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('t<"d-flex justify-content-between align-items-center"lip>') // Remove search input
            ->scrollX(true)
            ->orderBy(1);
    }

    /**
     * Define the columns for the table.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->width(30)
                ->addClass('text-center'),
            Column::make('nama_masyarakat')->title('Nama Masyarakat'),
            Column::make('nilai_rata_rata')->title('Nilai Rata-Rata'),
            Column::make('kategori_hasil')->title('Kategori Hasil'),
            Column::make('tanggal_isi')->title('Tanggal Isi'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->title('Aksi')
                ->addClass('text-center'),
        ];
    }

    /**
     * Optional: Filename if export used in the future.
     */
    protected function filename(): string
    {
        return 'HasilKuesioner_' . date('YmdHis');
    }
}
