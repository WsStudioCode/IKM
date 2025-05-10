@extends('layouts.app')

@section('content')
    {{-- Header --}}
    <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pertanyaan.index') }}">Pertanyaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pertanyaan</li>
        </ol>
    </nav>

    {{-- Form --}}
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('pertanyaan.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="isi_pertanyaan" class="form-label">Isi Pertanyaan</label>
                    <textarea name="isi_pertanyaan" id="isi_pertanyaan" rows="4" required class="form-control">{{ old('isi_pertanyaan') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pertanyaan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
