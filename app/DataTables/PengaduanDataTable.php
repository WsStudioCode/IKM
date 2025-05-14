<?php

namespace App\DataTables;

use App\Models\Pengaduan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PengaduanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('nama_masyarakat', fn($row) => $row->masyarakat->nama ?? '-')
            ->addColumn('tanggapan', fn($row) => $row->tindakLanjut->tanggapan ?? '-')
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.pengaduan.partials.actions', compact('row'))->render();
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Pengaduan $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['masyarakat', 'tindakLanjut']);

        if ($tahun = request('tahun')) {
            $query->whereYear('created_at', $tahun);
        }
        if ($search = request('search_custom')) {
            $query->where(function ($q) use ($search) {
                $q->where('status', 'like', "%{$search}%")
                    ->orWhereHas('masyarakat', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pengaduan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('t<"d-flex justify-content-between align-items-center"lip>')
            ->scrollX(true)
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->width(30)
                ->addClass('text-center'),
            Column::make('nama_masyarakat')->title('Nama'),
            Column::make('isi')->title('Isi Pengaduan'),
            Column::make('status')->title('Status'),
            Column::computed('tanggapan')->title('Tanggapan Admin'),
            Column::make('created_at')->title('Tanggal Pengaduan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center')
                ->title('Aksi'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pengaduan_' . date('YmdHis');
    }
}
