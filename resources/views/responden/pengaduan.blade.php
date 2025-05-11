<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Form Pengaduan</h1>
            <a href="{{ route('responden.masyarakat') }}" class="text-red-600 hover:underline font-medium">Dashboard</a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Sampaikan Pengaduan Anda</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="isi" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengaduan</label>
                <textarea id="isi" name="isi" rows="5"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                    required>{{ old('isi') }}</textarea>
                @error('isi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('responden.masyarakat') }}" class="text-gray-600 hover:underline">← Kembali ke
                    Dashboard</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Kirim
                    Pengaduan</button>
            </div>
        </form>
    </div>

</body>

</html>
