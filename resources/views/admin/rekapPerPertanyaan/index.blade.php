@extends('layouts.app')

@section('content')

        {{-- HEADER --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekap Kuesioner</li>
            </ol>
        </nav>
        <div class="card">

        {{-- <div class="card-header">Rekap Kuesioner per Pertanyaan</div> --}}
        <div class="card-body table-responsive">
            <form method="GET" action="{{ route('rekap.pertanyaan.index') }}" class="mb-4 d-flex align-items-end gap-2">
                <div>
                    <label for="from" class="form-label mb-0">Dari Tanggal</label>
                    <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div>
                    <label for="to" class="form-label mb-0">Sampai Tanggal</label>
                    <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('rekap.pertanyaan.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pertanyaan</th>
                        <th>Total Nilai</th>
                        <th>Total Responden</th>
                        <th>Rata-rata</th>
                        <th>Nilai IKM</th> <!-- Sudah diperbarui -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $item)
                        <tr>
                            <td>{{ $item->pertanyaan->isi_pertanyaan ?? '-' }}</td>
                            <td>{{ $item->total_skor }}</td>
                            <td>{{ $item->total_responden }}</td>
                            <td>{{ $item->rata_rata_jawaban }}</td>
                            <td>{{ number_format($item->rata_rata_jawaban * 0.11, 3) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <h5><strong>Nilai Akhir IKM:</strong> <strong>{{ number_format($nilaiAkhirIKM, 2) }}</strong></h5>
                <small>(Total dari seluruh Nilai IKM per pertanyaan dikalikan 25)</small>
            </div>
            
            <div class="mt-2">
                <h5><strong>Mutu Pelayanan:</strong> 
                    <span class="badge bg-{{ $warnaMutu }}">{{ $keteranganMutu }}</span>
                </h5>
            </div>

        </div>
    </div>
@endsection
