@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori-pertanyaan.index') }}">Kategori Pertanyaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Kategori Pertanyaan</li>
        </ol>
    </nav>

    {{-- FORM --}}
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

            <form method="POST" action="{{ route('kategori-pertanyaan.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}"
                        required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('kategori-pertanyaan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
