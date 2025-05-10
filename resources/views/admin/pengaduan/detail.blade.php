@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Forum Diskusi: {{ $pengaduan->masyarakat->nama }}</li>
        </ol>
    </nav>

    <div class="container px-0">
        {{-- Pengaduan Utama --}}
        <div class="card mb-4 border">
            <div class="card-body">
                <h5 class="card-title mb-3">Pengaduan Masyarakat</h5>
                <p class="card-text">{{ $pengaduan->isi }}</p>
                <div class="text-muted small mt-3">
                    Status: <strong>{{ $pengaduan->status }}</strong> |
                    Tanggal: {{ $pengaduan->created_at->translatedFormat('d F Y H:i') }}
                </div>
            </div>
        </div>

        {{-- Tindak Lanjut --}}
        @if ($pengaduan->tindakLanjut)
            <div class="card mb-4 border border-success">
                <div class="card-body text-success">
                    <h6 class="fw-semibold mb-2">Tanggapan Admin</h6>
                    <p class="mb-2">{{ $pengaduan->tindakLanjut->tanggapan }}</p>
                    <div class="small text-success">
                        Ditanggapi pada:
                        {{ $pengaduan->tindakLanjut->tanggal_tindak_lanjut->translatedFormat('d F Y H:i') }}
                    </div>
                </div>
            </div>
        @endif

        {{-- Komentar --}}
        <div class="card border">
            <div class="card-body">
                <h6 class="fw-semibold mb-4">Komentar Masyarakat</h6>

                @forelse ($komentar as $komen)
                    <div class="border-top pt-3 mt-3">
                        <p class="mb-1 fw-bold">{{ $komen->masyarakat->nama }}:</p>
                        <p class="mb-1">{{ $komen->isi }}</p>
                        <p class="text-muted small mb-0">{{ $komen->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-muted">Belum ada komentar.</p>
                @endforelse

                <div class="mt-4">
                    {{ $komentar->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
