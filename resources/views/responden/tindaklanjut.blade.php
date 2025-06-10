<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Indeks Kepuasan Masyarakat') }}</title>
    <link rel="icon" href="{{ asset('logo2.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-[#003366] text-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo2.png') }}" alt="Logo" class="w-auto h-12">
                <h1 class="text-2xl font-bold whitespace-nowrap">E-SKM PKB Kota Makassar</h1>
            </div>
            <a href="{{ url('/') }}"
                class="bg-white text-[#003366] px-4 py-1 rounded hover:bg-gray-100 transition font-medium text-sm">Beranda</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 space-y-10">
        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Loop semua pengaduan --}}
        @forelse ($pengaduan as $item)
            <div class="bg-white p-6 rounded shadow mb-6">
                {{-- Header --}}
                <div class="mb-2">
                    <h2 class="text-lg font-bold text-gray-800">#{{ $item->id }} - {{ $item->masyarakat->nama }}
                    </h2>
                    <p class="text-sm text-gray-500">{{ $item->created_at->format('d M Y H:i') }}</p>
                </div>

                {{-- Isi Pengaduan --}}
                <p class="mt-2 text-gray-700 mb-4">{{ $item->isi }}</p>


                {{-- Tindak Lanjut --}}
                @if ($item->tindakLanjut)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <p class="font-semibold text-blue-700">Tanggapan Admin:</p>
                        <p class="text-sm text-blue-700">{{ $item->tindakLanjut->tanggapan }}</p>
                        <p class="text-xs text-gray-600 mt-1">
                            {{ $item->tindakLanjut->tanggal_tindak_lanjut->format('d M Y H:i') }}</p>
                    </div>
                @else
                    <p class="text-sm italic text-gray-500 mb-4">Belum ada tanggapan dari admin.</p>
                @endif

                {{-- Komentar --}}
                <div class="mb-4">
                    <h3 class="text-md font-semibold mb-2">Komentar</h3>

                    @php
                        $jumlahKomentar = $item->komentar_count ?? $item->komentar->count();
                    @endphp

                    @if ($jumlahKomentar === 0)
                        <p class="text-sm text-gray-500">Belum ada komentar.</p>
                    @else
                        <a href="{{ route('tindak-lanjut.show', $item) }}"
                            class="text-blue-600 text-sm hover:underline">
                            {{ $jumlahKomentar }} Komentar →
                        </a>
                    @endif
                </div>



                {{-- Form Komentar --}}
                @if (session('masyarakat_id'))
                    <form method="POST" action="{{ route('tindak-lanjut.komentar', $item) }}">
                        @csrf
                        <textarea name="isi" rows="2" class="w-full border border-gray-300 rounded px-4 py-2 text-sm mb-2"
                            placeholder="Tulis komentar..." required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <p class="text-sm text-red-600 mb-1">{{ $message }}</p>
                        @enderror
                        <div class="text-right">
                            <button type="submit"
                                class="text-sm bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
                                Kirim Komentar
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm italic text-gray-500">Login atau isi data terlebih dahulu untuk memberi komentar.
                    </p>
                @endif
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada pengaduan yang tersedia.</p>
        @endforelse
    </div>

</body>

</html>
