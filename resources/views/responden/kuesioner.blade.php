<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kuesioner</title>
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


    <div class="max-w-4xl mx-auto px-6 py-8 bg-white shadow rounded mt-10">

        <h2 class="text-2xl font-bold mb-6">Kuesioner</h2>

        <form action="{{ route('kuesioner.submit') }}" method="POST">
            @csrf

            @foreach ($pertanyaan as $index => $item)
                <div class="mb-6">
                    <p class="font-semibold mb-2">{{ $index + 1 + ($page - 1) * 10 }}. {{ $item->isi_pertanyaan }}
                    </p>

                    <div class="space-y-2">
                        @foreach ([1 => 'Tidak Sesuai', 2 => 'Kurang Sesuai', 3 => 'Sesuai', 4 => 'Sangat Sesuai'] as $val => $label)
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="jawaban[{{ $item->id }}]" value="{{ $val }}"
                                    required class="text-blue-600">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('responden.masyarakat') }}" class="text-gray-600 hover:underline">
                    ← Kembali ke Dashboard
                </a>

                {{-- Navigasi pertanyaan --}}
                <div class="flex gap-4">
                    @if ($page > 1)
                        <a href="{{ route('kuesioner.form', ['page' => $page - 1]) }}"
                            class="text-blue-600 hover:underline">← Sebelumnya</a>
                    @endif

                    @if ($page < $totalPages)
                        <a href="{{ route('kuesioner.form', ['page' => $page + 1]) }}"
                            class="text-blue-600 hover:underline">Selanjutnya →</a>
                    @else
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Kirim</button>
                    @endif
                </div>
            </div>

        </form>
    </div>

</body>

</html>
