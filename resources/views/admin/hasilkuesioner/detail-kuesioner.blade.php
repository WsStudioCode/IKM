@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card">
        <div class="card-header bg-primary text-white">
            Detail Kuesioner Responden
        </div>
        <div class="card-body">
            {{-- Informasi Responden --}}
            <h5 class="mb-3">Informasi Responden</h5>
            <table class="table table-sm table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $masyarakat->nama }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $masyarakat->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th>Pendidikan</th>
                    <td>{{ $masyarakat->pendidikan->value ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengisian</th>
                    <td>{{ \Carbon\Carbon::parse($hasil->tanggal_isi)->translatedFormat('d F Y') }}</td>
                </tr>
                {{-- <tr>
                    <th>Nilai IKM</th>
                    <td><strong>{{ $hasil->nilai_rata_rata }}</strong></td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td><span class="badge bg-success">{{ $hasil->kategori_hasil }}</span></td>
                </tr> --}}
            </table>

            {{-- Jawaban Kuesioner --}}
            <h5 class="mt-4 mb-2">Jawaban Kuesioner</h5>
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jawaban as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->pertanyaan->isi_pertanyaan ?? '-' }}</td>
                            <td>
                                @php
                                    $opsi = [
                                        1 => ['label' => 'Tidak Sesuai', 'warna' => 'danger'],
                                        2 => ['label' => 'Kurang Sesuai', 'warna' => 'warning'],
                                        3 => ['label' => 'Sesuai', 'warna' => 'primary'],
                                        4 => ['label' => 'Sangat Sesuai', 'warna' => 'success'],
                                    ];
                                    $jawab = $opsi[$item->jawaban] ?? ['label' => '-', 'warna' => 'secondary'];
                                @endphp
                                <span class="badge bg-{{ $jawab['warna'] }}">
                                    {{ $jawab['label'] }} ({{ $item->jawaban }})
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('hasil-kuesioner.index') }}" class="btn btn-secondary mt-3">
                ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
