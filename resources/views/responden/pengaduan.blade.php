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
                <h1 class="text-2xl font-bold whitespace-nowrap">IKM - Indeks Kepuasan Masyarakat</h1>
            </div>
            <a href="{{ url('/') }}"
                class="bg-white text-[#003366] px-4 py-1 rounded hover:bg-gray-100 transition font-medium text-sm">Beranda</a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Sampaikan Pengaduan Anda</h2>

        @if (session('success'))
            <div id="success-alert"
                class="bg-green-100 text-green-700 p-4 rounded mb-4 transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @if ($errors->any())
                <div id="error-alert" class="bg-red-100 text-red-700 p-4 rounded mb-4 transition-opacity duration-500">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Lampiran Gambar
                    (Opsional)</label>
                <input type="file" name="gambar" id="gambar"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                    accept="image/*">
                @error('gambar')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror

                {{-- Preview --}}
                <div class="mt-4">
                    <img id="preview-gambar" src="#" alt="Preview Gambar"
                        class="hidden w-48 rounded border border-gray-300">
                </div>
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

    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview-gambar');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');

            if (successAlert) {
                setTimeout(() => {
                    alert.classList.add('opacity-0');
                    setTimeout(() => alert.remove(), 500);
                }, 2000);
            }

            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.classList.add('opacity-0');
                    setTimeout(() => errorAlert.remove(), 500);
                }, 4000);
            }
        });
    </script>


</body>

</html>
