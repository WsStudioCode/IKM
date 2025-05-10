@extends('layouts.app')

@section('content')
    {{-- STATISTIK --}}
    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="text-muted">Jumlah Masyarakat</h6>
                    <h3 class="text-primary">{{ $totalMasyarakat }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="text-muted">Jumlah Pertanyaan</h6>
                    <h3 class="text-success">{{ $totalPertanyaan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="text-muted">Jumlah Kategori</h6>
                    <h3 class="text-secondary">{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Pengaduan</h6>
                    <h3 class="text-dark">{{ $jumlahPengaduan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="text-muted">Menunggu</h6>
                    <h3 class="text-warning">{{ $jumlahMenunggu }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="text-muted">Diproses</h6>
                    <h3 class="text-primary">{{ $jumlahDiproses }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="text-muted">Selesai</h6>
                    <h3 class="text-success">{{ $jumlahSelesai }}</h3>
                </div>
            </div>
        </div>
    </div>



    {{-- CHART --}}
    <div class="mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Grafik Pengaduan Bulanan ({{ request('tahun') ?? date('Y') }})</span>
                <form method="GET" class="d-flex align-items-center">
                    <label for="tahun" class="me-2 mb-0 small">Tahun:</label>
                    <select name="tahun" id="tahun" class="form-select form-select-sm" onchange="this.form.submit()"
                        style="width: 100px;">
                        @foreach ($listTahun as $th)
                            <option value="{{ $th }}" @selected(request('tahun', date('Y')) == $th)>
                                {{ $th }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="chartPengaduan" class="w-100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Grafik Tingkat Kepuasan ({{ request('tahun') ?? date('Y') }})</span>
                <form method="GET" class="d-flex align-items-center">
                    <label for="tahun" class="me-2 mb-0 small">Tahun:</label>
                    <select name="tahun" id="tahun" class="form-select form-select-sm" onchange="this.form.submit()"
                        style="width: 100px;">
                        @foreach ($listTahun as $th)
                            <option value="{{ $th }}" @selected(request('tahun', date('Y')) == $th)>
                                {{ $th }}
                            </option>
                        @endforeach
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

    {{-- TABEL --}}
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

        const chart = new Chart(document.getElementById('chartKepuasan'), {
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
                            labelPointStyle: function() {
                                return {
                                    pointStyle: 'rectRounded',
                                    rotation: 0
                                };
                            }
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

        const chartPengaduan = new Chart(document.getElementById('chartPengaduan'), {
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
