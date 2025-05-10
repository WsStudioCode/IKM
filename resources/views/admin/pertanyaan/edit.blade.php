@extends('layouts.app')

@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Pertanyaan</h4>
    </div>

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

            <form method="POST" action="{{ route('pertanyaan.update', $pertanyaan->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="isi_pertanyaan" class="form-label">Isi Pertanyaan</label>
                    <textarea name="isi_pertanyaan" id="isi_pertanyaan" rows="4" required class="form-control">{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_id', $pertanyaan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pertanyaan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
