<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Indeks Kepuasan Masyarakat') }}</title>
    <link rel="icon" href="{{ asset('logo2.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    html {
        scroll-behavior: smooth;
    }
</style>
</head>

<body class="bg-gray-100 min-h-screen font-sans">

    {{-- <!-- Splash Screen -->
    <div id="splash-screen" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500" >
        <div class="text-center">
            <img src="{{ asset('logo2.png') }}" alt="Logo" class="mx-auto animate-pulse">
            <h2 class="text-xl mt-4 font-semibold text-[#003366]">Memuat Aplikasi...</h2>
        </div>
    </div> --}}

    {{-- Navbar --}}
    <nav class="bg-[#003366] text-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo2.png') }}" alt="Logo" class="w-auto h-12">
                <h1 class="text-2xl font-bold whitespace-nowrap">E-SKM PKB Kota Makassar</h1>
            </div>
            <a href="{{ url('/login') }}"
                class="bg-white text-[#003366] px-4 py-1 rounded hover:bg-gray-100 transition font-medium text-sm">Login
                Admin</a>
        </div>
    </nav>

    <div class="modal fade" id="cmsStatistik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-dark">
                    <div class="card w-100">
                        <div class="card-body">
                            <div id="polling"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-white p-6 rounded shadow mb-8">
            <h2 class="text-2xl font-semibold text-[#003366] mb-2">Selamat Datang di Layanan Masyarakat</h2>
            <p class="text-gray-600">Silakan pilih menu berikut untuk melanjutkan.</p>
        </div>

        {{-- Menu --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <a href="{{ route('kuesioner.form') }}"
                class="bg-[#004c99] text-white p-6 rounded shadow hover:bg-[#0066cc] transition text-center">
                <h3 class="text-lg font-semibold">Survey</h3>
                <p class="text-sm mt-2">Isi kuesioner pelayanan publik</p>
            </a>

            <a href="{{ route('pengaduan.form') }}"
                class="bg-[#004c99] text-white p-6 rounded shadow hover:bg-[#0066cc] transition text-center">
                <h3 class="text-lg font-semibold">Pengaduan</h3>
                <p class="text-sm mt-2">Sampaikan pengaduan Anda</p>
            </a>

            <a href="#tindak-lanjut"
                class="bg-[#004c99] text-white p-6 rounded shadow hover:bg-[#0066cc] transition text-center">
                <h3 class="text-lg font-semibold">Tindak Lanjut</h3>
                <p class="text-sm mt-2">Lihat status dan tanggapan</p>
            </a>
        </div>


        <div class="bg-white rounded shadow p-6 mb-10 flex flex-col md:flex-row gap-6">
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


        {{-- Bagian Tindak Lanjut --}}
        <div id="tindak-lanjut" class="space-y-10">

            <div class="w-full px-0">
                <div class="flex flex-col md:flex-row gap-6">

                    {{-- Kolom Kiri: Pengaduan --}}
                    <div class="w-full md:w-2/3 bg-white p-6 rounded shadow space-y-6">

                        {{-- Header + Tombol --}}
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-800">Pengaduan</h2>
                            {{-- <a href="{{ route('pengaduan.form') }}"
                                class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition text-sm">
                                + Buat Pengaduan
                            </a> --}}
                        </div>

                        {{-- Filter --}}
                        <form action="{{ route('responden.masyarakat') }}" method="GET"
                            class="bg-gray-100 p-4 rounded mb-6">
                            <div class="flex gap-4">
                                <input type="text" name="q" value="{{ request('q') }}"
                                    class="border rounded px-3 py-2 w-full" placeholder="Cari Pengaduan...">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm whitespace-nowrap">
                                    Cari
                                </button>
                            </div>
                        </form>


                        @if (request('q'))
                            <p class="text-sm text-gray-600 mb-4">
                                Hasil pencarian untuk: <strong>"{{ request('q') }}"</strong>
                            </p>
                        @endif



                        {{-- Daftar Pengaduan --}}
                        @forelse ($pengaduan as $item)
                            <div class="bg-white p-4 rounded shadow border">
                                {{-- Header Pengaduan --}}
                                <div class="mb-2 flex justify-between">
                                    <h3 class="text-md font-semibold text-blue-600">
                                        #{{ $item->id }} - {{ $item->masyarakat->nama ?? 'Noname' }}
                                    </h3>
                                    <span class="text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="text-gray-700 mb-2">{{ $item->isi }}</p>

                                @if ($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Pengaduan"
                                        class="w-32 rounded shadow mb-2">
                                @endif

                                @if ($item->tindakLanjut)
                                    <div class="space-y-3">
                                        @foreach ($item->tindakLanjut->tanggapan as $i => $tgpt)
                                            <div
                                                class="flex items-start gap-3 bg-blue-50 p-3 rounded-lg shadow-sm border border-blue-200">
                                                <div class="flex-1">
                                                    <p class="text-sm text-blue-900 font-medium mb-1">Tanggapan Admin:
                                                    </p>
                                                    <p class="text-sm text-gray-800">{{ $tgpt }}</p>

                                                    @if (!empty($item->tindakLanjut->gambar[$i]))
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $item->tindakLanjut->gambar[$i]) }}"
                                                                alt="Gambar Tanggapan" class="w-28 rounded border">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs italic text-gray-400">Belum ada tanggapan admin</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Belum ada pengaduan.</p>
                        @endforelse

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $pengaduan->links() }}
                        </div>
                    </div>

                    {{-- Kolom Kanan: Info Tambahan --}}
                    <div class="w-full md:w-1/3 space-y-6">

                        {{-- Pelapor Terbaru --}}
                        <div class="bg-white rounded shadow p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold text-gray-700">Pelapor Terbaru</h4>
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">
                                    {{ $pelaporTerbaru->count() }}
                                    {{ $pelaporTerbaru->count() === 1 ? 'User' : 'Users' }}</span>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach ($pelaporTerbaru as $pelapor)
                                    <div class="text-center">
                                        <img src="{{ asset('icon2.png') }}" class="w-10 h-10 rounded-full mx-auto">
                                        <p class="text-xs truncate">{{ $pelapor->nama ?? 'Noname' }}</p>
                                        {{-- <p class="text-[10px] text-gray-500">
                                            {{ $pelapor->created_at->format('d/m/Y') }}</p> --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Laporan Sukses --}}
                        <div class="bg-white rounded shadow p-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Laporan Sukses</h4>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                @forelse ($laporanSukses as $lapor)
                                    <li>{{ Str::limit($lapor->isi, 50) }}</li>
                                @empty
                                    <li class="text-gray-400 italic">Belum ada laporan selesai</li>
                                @endforelse
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <footer class="bg-[#003366] text-white mt-16">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center">
            <p class="text-sm font-semibold">© {{ date('Y') }} Pemerintah Kota Makasar</p>
            <p class="text-xs mt-1">Sistem Informasi Pengaduan dan Indeks Kepuasan Masyarakat</p>
        </div>
    </footer>

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Terima Kasih!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Tutup'
        });
    </script>
    @endif


    @if (!empty($waLink))
        <div id="wa-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md text-center">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Notifikasi WhatsApp</h2>
                <p class="text-gray-700 mb-6">Ingin mengirim pengaduan ini langsung ke WhatsApp Admin?</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ $waLink }}" target="_blank"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        Kirim Pengaduan via WhatsApp
                    </a>
                    <button onclick="document.getElementById('wa-modal').classList.add('hidden')"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

</body>

</html>
