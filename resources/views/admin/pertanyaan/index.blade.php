@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <nav aria-label="breadcrumb" class="mb-3 d-flex justify-content-between align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pertanyaan</li>
        </ol>
        <a href="{{ route('pertanyaan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Pertanyaan
        </a>
    </nav>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped w-100'], true) !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/lightbox/fslightbox.js') }}"></script>
    {{ $dataTable->scripts() }}
@endpush
