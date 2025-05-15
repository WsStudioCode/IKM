@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Pengaduan</h4>
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

            <form method="POST" action="{{ route('pengaduan.update', $pengaduan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Masyarakat</label>
                    <input type="text" value="{{ $pengaduan->masyarakat->nama }}" class="form-control bg-light" disabled>
                    <input type="hidden" name="masyarakat_id" value="{{ $pengaduan->masyarakat_id }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Isi Pengaduan</label>
                    <textarea class="form-control bg-light" rows="4" disabled>{{ $pengaduan->isi }}</textarea>
                    <input type="hidden" name="isi" value="{{ $pengaduan->isi }}">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Menunggu" {{ old('status', $pengaduan->status) == 'Menunggu' ? 'selected' : '' }}>
                            Menunggu</option>
                        <option value="Diproses" {{ old('status', $pengaduan->status) == 'Diproses' ? 'selected' : '' }}>
                            Diproses</option>
                        <option value="Selesai" {{ old('status', $pengaduan->status) == 'Selesai' ? 'selected' : '' }}>
                            Selesai</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
