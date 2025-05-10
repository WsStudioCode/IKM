@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Kategori Pertanyaan</h4>
    </div>

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

            <form method="POST" action="{{ route('kategori-pertanyaan.update', $kategoriPertanyaan->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="{{ old('nama', $kategoriPertanyaan->nama) }}" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('kategori-pertanyaan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
