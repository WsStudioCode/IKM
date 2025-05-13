@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tindak Lanjut: {{ $pengaduan->masyarakat->nama }}</li>
        </ol>
    </nav>

    <div class="container px-0">
        {{-- Pengaduan Utama --}}
        <div class="card mb-4 border">
            <div class="card-body">
                <h5 class="card-title mb-3">Pengaduan Masyarakat</h5>
                <p class="card-text">{{ $pengaduan->isi }}</p>

                @if ($pengaduan->gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $pengaduan->gambar) }}" alt="Gambar Pengaduan"
                            class="img-fluid rounded shadow-sm" style="max-width: 300px;">
                    </div>
                @endif

                <div class="text-muted small mt-3">
                    Status: <strong>{{ $pengaduan->status }}</strong> |
                    Tanggal: {{ $pengaduan->created_at->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>

        {{-- Daftar Tanggapan --}}

        @if ($pengaduan->tindakLanjut)
            @php
                $tanggapans = $pengaduan->tindakLanjut->tanggapan ?? '[]';
                $gambarList = $pengaduan->tindakLanjut->gambar ?? [];
            @endphp

            @foreach ($tanggapans as $index => $tanggapan)
                <div class="card mb-3 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="text-success">Admin</strong>
                            <span class="text-muted small">
                                {{ $pengaduan->tindakLanjut->tanggal_tindak_lanjut->translatedFormat('d F Y H:i') }}
                            </span>
                        </div>
                        <p>{{ $tanggapan }}</p>

                        @if (!empty($gambarList[$index]))
                            <img src="{{ asset('storage/' . $gambarList[$index]) }}" alt="Gambar Tanggapan"
                                class="img-thumbnail" style="max-width: 250px;">
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Tombol Tanggapi --}}
        <div class="text-end mb-3">
            <button class="btn btn-primary" onclick="document.getElementById('form-tanggapan').classList.toggle('d-none')">
                + Tanggapi
            </button>
        </div>

        {{-- Form Tanggapan --}}
        <div id="form-tanggapan" class="card d-none">
            <div class="card-body">
                <form action="{{ route('tindak-lanjut.tanggapan.store', $pengaduan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Hidden fields for pengaduan data --}}
                    <input type="hidden" name="masyarakat_id" value="{{ $pengaduan->masyarakat_id }}">
                    <input type="hidden" name="isi" value="{{ $pengaduan->isi }}">
                    <input type="hidden" name="status" value="{{ $pengaduan->status }}">

                    <div class="mb-3">
                        <label for="tanggapan" class="form-label">Tanggapan</label>
                        <textarea name="tanggapan" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Lampiran Gambar
                            (Opsional)</label>
                        <input type="file" name="gambar" id="gambar"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                            accept="image/*">
                        @error('gambar')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Preview --}}
                        <div class="mt-4">
                            <img id="preview-gambar" src="#" alt="Preview Gambar"
                                class="hidden w-48 rounded border border-gray-300">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Kirim Tanggapan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview-gambar');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.classList.add('hidden');
            }
        });
    </script>
@endsection
