@extends('layouts.app')

@section('content')
    {{-- STATISTIK --}}
    <div class="row g-4 mb-4">
        @php
            $stats = [
                ['label' => 'Jumlah Masyarakat', 'value' => $totalMasyarakat, 'class' => 'text-primary'],
                ['label' => 'Jumlah Pertanyaan', 'value' => $totalPertanyaan, 'class' => 'text-success'],
                ['label' => 'Jumlah Kategori', 'value' => $totalKategori, 'class' => 'text-secondary'],
                ['label' => 'Total Pengaduan', 'value' => $jumlahPengaduan, 'class' => 'text-dark'],
                ['label' => 'Menunggu', 'value' => $jumlahMenunggu, 'class' => 'text-warning'],
                ['label' => 'Diproses', 'value' => $jumlahDiproses, 'class' => 'text-primary'],
                ['label' => 'Selesai', 'value' => $jumlahSelesai, 'class' => 'text-success'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="col-md-2">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ $stat['label'] }}</h6>
                        <h3 class="{{ $stat['class'] }}">{{ $stat['value'] }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card bg-white rounded p-6 mb-10 flex flex-col md:flex-row gap-6">
        {{-- Tabel Statistik dengan Header NILAI IKM --}}
        <div class="w-full md:w-full">
            <table class="w-full border border-gray-400 text-sm text-gray-800">
                <thead>
                    <tr class="bg-[#003366] text-white">
                        <th colspan="3" class="text-center text-lg font-bold py-3">NILAI IKM</th>
                    </tr>
                    <tr class="bg-gray-100 text-center font-semibold">
                        <th class="border px-2 py-1 w-1/3">Kategori</th>
                        <th class="border px-2 py-1 w-1/3">Keterangan</th>
                        <th class="border px-2 py-1 w-1/3">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-2 py-1">Nilai IKM</td>
                        <td class="border px-2 py-1 text-center font-bold">Total</td>
                        <td class="border px-2 py-1 text-center text-xl font-extrabold">{{ $nilaiIKM }}</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1">Jumlah Responden</td>
                        <td class="border px-2 py-1">Responden</td>
                        <td class="border px-2 py-1 text-center">{{ $jumlahResponden }} orang</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1" rowspan="2">Jenis Kelamin</td>
                        <td class="border px-2 py-1">Perempuan</td>
                        <td class="border px-2 py-1 text-center">{{ $wanita }} orang</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1">Laki-laki</td>
                        <td class="border px-2 py-1 text-center">{{ $pria }} orang</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1" rowspan="4">Pendidikan</td>
                        <td class="border px-2 py-1">SMA/SMK Sederajat</td>
                        <td class="border px-2 py-1 text-center">{{ $pendidikan['SMA_SMK'] ?? 0 }} orang</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1">D1 D2 D3</td>
                        <td class="border px-2 py-1 text-center">{{ $pendidikan['D1-D3'] ?? 0 }} orang</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1">D4 S1</td>
                        <td class="border px-2 py-1 text-center">{{ $pendidikan['D4-S1'] ?? 0 }} orang</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1">S2 S3</td>
                        <td class="border px-2 py-1 text-center">{{ $pendidikan['S2-S3'] ?? 0 }} orang</td>
                    </tr>
                    <tr>
                        <td class="border px-2 py-1">Periode Survei</td>
                        <td class="border px-2 py-1">Rentang</td>
                        <td class="border px-2 py-1 text-center">{{ $periode['awal'] }} – {{ $periode['akhir'] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- GRAFIK PENGADUAN --}}
    <div class="mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Grafik Pengaduan Bulanan ({{ $tahunPengaduan }})</span>
                <form method="GET" class="d-flex align-items-center">
                    <label for="tahun_pengaduan" class="me-2 mb-0 small">Tahun:</label>
                    <select name="tahun_pengaduan" id="tahun_pengaduan" class="form-select form-select-sm"
                        onchange="this.form.submit()" style="width: 100px;">
                        @foreach ($listTahun as $th)
                            <option value="{{ $th }}" @selected($tahunPengaduan == $th)>
                                {{ $th }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="tahun_kepuasan" value="{{ $tahunKepuasan }}">
                </form>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="chartPengaduan" class="w-100"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK KEPUASAN --}}
    <div class="mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Grafik Tingkat Kepuasan ({{ $tahunKepuasan }})</span>
                <form method="GET" class="d-flex align-items-center gap-3 flex-wrap">
                    <input type="hidden" name="tahun_pengaduan" value="{{ $tahunPengaduan }}">
                    <input type="hidden" name="tahun_kepuasan" value="{{ $tahunKepuasan }}">

                    {{-- Dropdown Filter Periode --}}
                    <label for="periode_kepuasan" class="mb-0 small">Periode:</label>
                    <select name="periode_kepuasan" id="periode_kepuasan" class="form-select form-select-sm"
                        onchange="this.form.submit()" style="width: 120px;">
                        <option value="3" {{ request('periode_kepuasan') == '3' ? 'selected' : '' }}>3 Bulan</option>
                        <option value="6" {{ request('periode_kepuasan') == '6' ? 'selected' : '' }}>6 Bulan</option>
                        <option value="12" {{ request('periode_kepuasan', '12') == '12' ? 'selected' : '' }}>1 Tahun
                        </option>
                    </select>


                </form>

            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="chartKepuasan" class="w-100" style="display: block;"></canvas>
                </div>
            </div>
            <div class="card-footer bg-white p-3">
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <div class="d-flex align-items-center"><span class="badge bg-success me-2"
                            style="width: 30px;">&nbsp;</span><span class="small">Sangat Sesuai</span></div>
                    <div class="d-flex align-items-center"><span class="badge bg-primary me-2"
                            style="width: 30px;">&nbsp;</span><span class="small">Sesuai</span></div>
                    <div class="d-flex align-items-center"><span class="badge bg-warning me-2"
                            style="width: 30px;">&nbsp;</span><span class="small">Kurang Sesuai</span></div>
                    <div class="d-flex align-items-center"><span class="badge bg-danger me-2"
                            style="width: 30px;">&nbsp;</span><span class="small">Tidak Sesuai</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL KEPUASAN --}}
    <div class="mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Data Kuesioner</span>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive p-3">
                    @include('components.table-kuesioner')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Figtree', 'sans-serif'";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#666';

        new Chart(document.getElementById('chartKepuasan'), {
            type: 'line',
            data: {
                labels: @json($grafik['bulan']),
                datasets: [{
                        label: 'Sangat Sesuai',
                        data: @json($grafik['Sangat Sesuai']),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#10b981'
                    },
                    {
                        label: 'Sesuai',
                        data: @json($grafik['Sesuai']),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#3b82f6'
                    },
                    {
                        label: 'Kurang Sesuai',
                        data: @json($grafik['Kurang Sesuai']),
                        borderColor: '#facc15',
                        backgroundColor: 'rgba(250, 204, 21, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#facc15'
                    },
                    {
                        label: 'Tidak Sesuai',
                        data: @json($grafik['Tidak Sesuai']),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#ef4444'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255,255,255,0.95)',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: '#e9e9e9',
                        borderWidth: 1,
                        padding: 10,
                        usePointStyle: true,
                        callbacks: {
                            labelPointStyle: () => ({
                                pointStyle: 'rectRounded',
                                rotation: 0
                            })
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        },
                        grid: {
                            borderDash: [3, 3]
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartPengaduan'), {
            type: 'bar',
            data: {
                labels: @json($grafik['bulan']),
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: @json($grafikPengaduan),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            borderDash: [3, 3]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255,255,255,0.95)',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: '#e9e9e9',
                        borderWidth: 1,
                        padding: 10,
                    }
                }
            }
        });
    </script>
@endpush
