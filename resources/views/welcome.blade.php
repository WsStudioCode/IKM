<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Masyarakat</title>

    <!-- ✅ CDN TailwindCSS versi stabil langsung dari tailwindcss.com -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">IKM - Indeks Kepuasan Masyarakat</h1>
            <a href="{{ route('login') }}" class="text-red-600 hover:underline font-medium">Login Admin</a>
        </div>
    </nav>

    <!-- Form Card -->
    <div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Formulir Data Masyarakat</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('masyarakat.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Umur</label>
                <input type="number" name="umur" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pendidikan</label>
                <input type="text" name="pendidikan" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
                    <option value="Hindu">Hindu</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Budha">Budha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full mt-1 p-2 border border-gray-300 rounded" required></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="no_telp" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            <div class="md:col-span-2 text-right mt-4">
                <button type="submit"
                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">Kirim</button>
            </div>
        </form>
    </div>

</body>

</html>
