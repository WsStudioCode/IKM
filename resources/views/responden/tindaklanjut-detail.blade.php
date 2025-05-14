<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-[#003366] text-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo2.png') }}" alt="Logo" class="w-auto h-12">
                <h1 class="text-2xl font-bold whitespace-nowrap">IKM - Indeks Kepuasan Masyarakat</h1>
            </div>
            <a href="{{ url('/') }}"
                class="bg-white text-[#003366] px-4 py-1 rounded hover:bg-gray-100 transition font-medium text-sm">Beranda</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pengaduan --}}
        <div class="mb-6 border-b pb-4">
            <h2 class="text-lg font-bold text-gray-800">Pengaduan</h2>
            <p class="text-sm text-gray-600">Oleh: {{ $pengaduan->masyarakat->nama }} -
                {{ $pengaduan->created_at->format('d M Y H:i') }}</p>
            <p class="mt-2 text-gray-700">{{ $pengaduan->isi }}</p>
        </div>

        {{-- Tanggapan Admin --}}
        @if ($pengaduan->tindakLanjut)
            <div class="mb-6 border-l-4 border-blue-500 bg-blue-50 p-4 rounded">
                <h2 class="font-bold text-blue-700">Tanggapan Admin</h2>
                <p class="text-sm text-blue-700 mt-1">{{ $pengaduan->tindakLanjut->tanggapan }}</p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $pengaduan->tindakLanjut->tanggal_tindak_lanjut->format('d M Y H:i') }}</p>
            </div>
        @else
            <p class="text-sm text-gray-500 italic mb-6">Belum ada tanggapan dari admin.</p>
        @endif

        {{-- Semua Komentar --}}
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-2">Komentar</h2>
            @forelse ($pengaduan->komentar as $komentar)
                <div class="border border-gray-200 p-3 rounded mb-2">
                    <p class="text-sm text-gray-600 font-semibold">{{ $komentar->masyarakat->nama }}</p>
                    <p class="text-gray-700 text-sm mt-1">{{ $komentar->isi }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada komentar.</p>
            @endforelse
        </div>

        {{-- Form Komentar --}}
        @if (session('masyarakat_id'))
            <form method="POST" action="{{ route('tindak-lanjut.komentar', $pengaduan) }}">
                @csrf
                <div class="mb-4">
                    <label for="isi" class="block text-sm font-medium text-gray-700 mb-1">Tulis Komentar</label>
                    <textarea name="isi" id="isi" rows="3"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                        required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="text-right">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Kirim</button>
                </div>
            </form>
        @else
            <p class="text-sm text-gray-500 italic">Silakan isi data diri terlebih dahulu untuk mengomentari.</p>
        @endif

    </div>

</body>

</html>
