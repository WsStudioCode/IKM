<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Indeks Kepuasan Masyarakat') }}</title>
    <link rel="icon" href="{{ asset('logo2.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
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

    <!-- Form Card -->
    <div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Formulir Data Masyarakat</h2>

        @if (session('success'))
            <div id="success-alert"
                class="bg-green-100 text-green-700 p-4 rounded mb-4 transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('masyarakat.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

            {{-- <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div> --}}

            <input type="hidden" name="nama" value="Responden" readonly class="w-full mt-1 p-2 border border-gray-300 rounded" required>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Umur</label>
                <input type="number" name="umur" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                <select name="pendidikan" id="pendidikan" class="w-full mt-1 p-2 border border-gray-300 rounded"
                    required>
                    <option value="">-- Pilih Pendidikan --</option>
                    @foreach (\App\Enums\PendidikanEnum::cases() as $item)
                        <option value="{{ $item->value }}"
                            {{ old('pendidikan', $masyarakat->pendidikan->value ?? '') === $item->value ? 'selected' : '' }}>
                            {{ $item->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            {{-- <div>
                <label class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
                    <option value="Hindu">Hindu</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Budha">Budha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div> --}}
            {{-- <div style="display: none;">
                <label class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
                    <option value="Hindu" selected>Hindu</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Budha">Budha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div> --}}

            <input type="hidden" name="alamat" value="-" readonly class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            <input type="hidden" name="no_telp" value="-" readonly class="w-full mt-1 p-2 border border-gray-300 rounded" required>

            {{-- <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full mt-1 p-2 border border-gray-300 rounded" required></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="no_telp" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div> --}}

            <div class="md:col-span-2 flex justify-between items-center mt-4">
                <a href="{{ url('/') }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                    Back
                </a>
                <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                    Kirim
                </button>
            </div>
        </form>
    </div>

    <script>
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
