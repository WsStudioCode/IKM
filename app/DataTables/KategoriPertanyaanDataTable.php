<?php

namespace App\DataTables;

use App\Models\KategoriPertanyaan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KategoriPertanyaanDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', fn($row) => Carbon::parse($row->created_at)->translatedFormat('d F Y H:i'))
            ->editColumn('updated_at', fn($row) => Carbon::parse($row->updated_at)->translatedFormat('d F Y H:i'))
            ->addColumn('action', function ($row) {
                return view('admin.kategori.partials.actions', compact('row'))->render();
            })
            ->setRowId('id');
    }

    public function query(KategoriPertanyaan $model): QueryBuilder
    {
        return $model->newQuery()->orderByDesc('created_at');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kategori-pertanyaan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->scrollX(true)
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                [
                    'extend' => 'excel',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-md me-2',
                ],
                [
                    'extend' => 'pdf',
                    'text' => '<i class="fas fa-file-pdf"></i>',
                    'className' => 'btn btn-md me-2',
                ],
                [
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-md me-2',
                ],
                [
                    'text' => '<i class="fas fa-sync-alt"></i>',
                    'className' => 'btn btn-md',
                    'action' => 'function ( e, dt, node, config ) { dt.ajax.reload(); }',
                ],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('No')->width(30)->addClass('text-center'),
            Column::make('nama')->title('Nama Kategori'),
            Column::make('created_at')->title('Dibuat'),
            Column::make('updated_at')->title('Diperbarui'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'KategoriPertanyaan_' . date('YmdHis');
    }
}
