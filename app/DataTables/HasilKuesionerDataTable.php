<?php

namespace App\DataTables;

use App\Models\HasilKuesioner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class HasilKuesionerDataTable extends DataTable
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
            ->addColumn('nama_masyarakat', function ($row) {
                return $row->masyarakat->nama ?? '-';
            })
            ->editColumn('tanggal_isi', function ($row) {
                return Carbon::parse($row->tanggal_isi)->translatedFormat('d F Y H:i');
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
        return $model->newQuery()->with('masyarakat');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('hasilkuesioner-table')
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
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'HasilKuesioner_' . date('YmdHis');
    }
}
