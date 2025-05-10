<?php

namespace App\DataTables;

use App\Models\Masyarakat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MasyarakatDataTable extends DataTable
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
            ->editColumn('tanggal_mengisi', function ($row) {
                return Carbon::parse($row->tanggal_mengisi)->translatedFormat('d F Y H:i');
            })
            ->editColumn('created_at', fn($row) => Carbon::parse($row->created_at)->translatedFormat('d F Y H:i'))
            ->editColumn('updated_at', fn($row) => Carbon::parse($row->updated_at)->translatedFormat('d F Y H:i'))
            ->addColumn('action', function ($row) {
                return view('admin.masyarakat.partials.actions', compact('row'))->render();
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Masyarakat $model): QueryBuilder
    {
        return $model->newQuery()->orderByDesc('created_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('masyarakat-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->scrollX(true)
            ->orderBy(1)
            ->selectStyleSingle()
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
            Column::make('nama')->title('Nama'),
            Column::make('umur')->title('Umur'),
            Column::make('jenis_kelamin')->title('Jenis Kelamin'),
            Column::make('pendidikan')->title('Pendidikan'),
            Column::make('pekerjaan')->title('Pekerjaan'),
            Column::make('agama')->title('Agama'),
            Column::make('alamat')->title('Alamat'),
            Column::make('no_telp')->title('No. Telepon'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->title('Aksi')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Masyarakat_' . date('YmdHis');
    }
}
