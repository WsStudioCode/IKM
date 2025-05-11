<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-md mb-6">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">IKM Dashboard</h1>
            <a href="{{ url('/') }}" class="text-red-600 hover:underline font-medium">Beranda</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Selamat Datang!</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Kuesioner --}}
            <a href="{{ route('kuesioner.form') }}"
                class="bg-white p-6 rounded shadow hover:shadow-md transition text-center">
                <h3 class="text-lg font-semibold text-gray-700">Kuesioner</h3>
                <p class="text-sm text-gray-500 mt-2">Isi kuesioner pelayanan publik</p>
            </a>

            {{-- Pengaduan --}}
            <a href="{{ route('pengaduan.form') }}"
                class="bg-white p-6 rounded shadow hover:shadow-md transition text-center">
                <h3 class="text-lg font-semibold text-gray-700">Pengaduan</h3>
                <p class="text-sm text-gray-500 mt-2">Sampaikan pengaduan Anda</p>
            </a>

            {{-- Tindak Lanjut --}}
            <a href="{{ route('tindak-lanjut.index') }}"
                class="bg-white p-6 rounded shadow hover:shadow-md transition text-center">
                <h3 class="text-lg font-semibold text-gray-700">Tindak Lanjut</h3>
                <p class="text-sm text-gray-500 mt-2">Lihat status pengaduan Anda</p>
            </a>
        </div>

    </div>

</body>

</html>
