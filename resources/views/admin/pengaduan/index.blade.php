@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengaduan Masyarakat</li>
        </ol>
    </nav>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body">
            {{-- FILTER DAN EXPORT --}}
            <div class="d-flex justify-content-between flex-wrap align-items-center mb-3 gap-2">
                <div class="d-flex align-items-center gap-3 flex-wrap">

                    {{-- Filter Tahun --}}
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-tahun" class="mb-0 small">Tahun:</label>
                        <select id="filter-tahun" class="form-select form-select-sm" style="width: 100px;"></select>
                    </div>

                    {{-- Filter Nama atau Kategori --}}
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-search" class="mb-0 small">Cari:</label>
                        <input type="text" id="filter-search" class="form-control form-control-sm"
                            placeholder="Nama Pengaduan" style="width: 200px;">
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
                data.tahun = $('#filter-tahun').val();
                data.search_custom = $('#filter-search').val();
            });


            $('#filter-tahun').on('change', function() {
                table.ajax.reload();
            });

            $('#filter-search').on('input', function() {
                table.ajax.reload();
            });

            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                const tahun = $('#filter-tahun').val();
                const search = $('#filter-search').val();
                const url = "{{ route('pengaduan.export.excel') }}?tahun=" + tahun + "&search=" +
                    encodeURIComponent(search);
                window.open(url, '_blank');
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                const tahun = $('#filter-tahun').val();
                const search = $('#filter-search').val();
                const url = "{{ route('pengaduan.export.pdf') }}?tahun=" + tahun + "&search=" +
                    encodeURIComponent(search);
                window.open(url, '_blank');
            });
        });
    </script>
@endpush
