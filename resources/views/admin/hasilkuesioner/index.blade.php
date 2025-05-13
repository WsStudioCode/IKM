@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hasil Kuesioner</li>
        </ol>
    </nav>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body">
            {{-- FILTER DAN EXPORT --}}
            <div class="d-flex justify-content-between flex-wrap align-items-center mb-3 gap-2">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    {{-- Filter Periode --}}
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-periode" class="mb-0 small">Periode:</label>
                        <select id="filter-periode" class="form-select form-select-sm" style="width: 110px;">
                            <option value="12">1 Tahun</option>
                            <option value="6">6 Bulan</option>
                            <option value="3">3 Bulan</option>
                        </select>
                    </div>

                    {{-- Filter Tahun --}}
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-tahun" class="mb-0 small">Tahun:</label>
                        <select id="filter-tahun" class="form-select form-select-sm" style="width: 100px;"></select>
                    </div>

                    {{-- Filter Nama atau Kategori --}}
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-search" class="mb-0 small">Cari:</label>
                        <input type="text" id="filter-search" class="form-control form-control-sm"
                            placeholder="Nama atau Kategori" style="width: 200px;">
                    </div>

                </div>

                {{-- Tombol Export --}}
                <div class="d-flex gap-2">
                    <a id="export-excel" href="#" class="btn btn-success btn-sm text-white">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a id="export-pdf" href="#" class="btn btn-danger btn-sm text-white">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>

            {{-- TABEL --}}
            <div style="overflow-x: auto;">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped nowrap w-100'], true) !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function() {
            const tableId = "{{ $dataTable->getTableAttribute('id') }}";
            const table = window.LaravelDataTables[tableId];


            const currentYear = new Date().getFullYear();
            for (let y = currentYear; y >= 2020; y--) {
                $('#filter-tahun').append(`<option value="${y}">${y}</option>`);
            }
            $('#filter-tahun').val(currentYear);

            table.on('preXhr.dt', function(e, settings, data) {
                data.periode = $('#filter-periode').val();
                data.tahun = $('#filter-tahun').val();
                data.search_custom = $('#filter-search').val();
            });


            $('#filter-periode, #filter-tahun').on('change', function() {
                table.ajax.reload();
            });

            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                const periode = $('#filter-periode').val();
                const tahun = $('#filter-tahun').val();
                const url = "{{ route('hasilkuesioner.export.excel') }}?periode=" + periode + "&tahun=" +
                    tahun;
                window.open(url, '_blank');
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                const periode = $('#filter-periode').val();
                const tahun = $('#filter-tahun').val();
                const url = "{{ route('hasilkuesioner.export.pdf') }}?periode=" + periode + "&tahun=" +
                    tahun;
                window.open(url, '_blank');
            });

            $('#filter-search').on('input', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
