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
            <div style="overflow-x: auto;">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped nowrap w-100'], true) !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
