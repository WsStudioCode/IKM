<?php

namespace App\DataTables;

use App\Models\Pertanyaan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PertanyaanDataTable extends DataTable
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
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d F Y H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('d F Y H:i');
            })
            ->addColumn('action', function ($row) {
                return view('admin.pertanyaan.partials.actions', compact('row'))->render();
            })
            ->addColumn('kategori', function ($row) {
                return $row->kategori?->nama ?? '-';
            })
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(Pertanyaan $model): QueryBuilder
    {
        return $model->newQuery()->with('kategori');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pertanyaan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->scrollX(true)
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
                    'text' => '<i class="fas fa-sync-alt"></i>',
                    'className' => 'btn btn-md',
                    'action' => 'function ( e, dt, node, config ) { dt.ajax.reload(); }',
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
            Column::make('isi_pertanyaan')->title('Pertanyaan'),
            Column::make('kategori'),
            Column::make('created_at')->title('Dibuat'),
            Column::make('updated_at')->title('Diperbarui'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pertanyaan_' . date('YmdHis');
    }
}
