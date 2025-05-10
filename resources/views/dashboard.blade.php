<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard IKM
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        {{-- CARD STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-gray-500">Jumlah Masyarakat</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalMasyarakat }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-gray-500">Jumlah Pertanyaan</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalPertanyaan }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-gray-500">Jumlah Kategori</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $totalKategori }}</p>
            </div>
        </div>

        {{-- GRID TABEL & CHART --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- TABLE --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg mb-4">Data Kuesioner</h3>
                @include('components.table-kuesioner')
            </div>

            {{-- CHART --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Grafik Tingkat Kepuasan ({{ request('tahun') ?? date('Y') }})</h3>

                    <form method="GET" class="flex items-center space-x-2">
                        <label for="tahun" class="text-sm text-gray-700">Tahun:</label>
                        <select name="tahun" id="tahun" class="border rounded px-2 py-1 text-sm"
                            onchange="this.form.submit()">
                            @foreach ($listTahun as $th)
                                <option value="{{ $th }}" @selected(request('tahun', date('Y')) == $th)>{{ $th }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                </div>

                <canvas id="chartKepuasan" class="w-full h-64"></canvas>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const chart = new Chart(document.getElementById('chartKepuasan'), {
                type: 'line',
                data: {
                    labels: @json($grafik['bulan']),
                    datasets: [{
                            label: 'Sangat Sesuai',
                            data: @json($grafik['Sangat Sesuai']),
                            borderColor: '#10b981',
                            fill: false
                        },
                        {
                            label: 'Sesuai',
                            data: @json($grafik['Sesuai']),
                            borderColor: '#3b82f6',
                            fill: false
                        },
                        {
                            label: 'Kurang Sesuai',
                            data: @json($grafik['Kurang Sesuai']),
                            borderColor: '#facc15',
                            fill: false
                        },
                        {
                            label: 'Tidak Sesuai',
                            data: @json($grafik['Tidak Sesuai']),
                            borderColor: '#ef4444',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
