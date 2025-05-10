<?php

namespace App\DataTables;

use App\Models\Pengaduan;
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
        return $model->newQuery()->with(['masyarakat', 'tindakLanjut']);
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
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->scrollX(true)
            ->buttons([
                ['extend' => 'excel', 'text' => 'Export Excel'],
                ['extend' => 'pdf', 'text' => 'Export PDF'],
                ['extend' => 'print', 'text' => 'Print'],
                [
                    'text' => 'Reload',
                    'action' => 'function ( e, dt, node, config ) { dt.ajax.reload(); }'
                ],
            ]);
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
