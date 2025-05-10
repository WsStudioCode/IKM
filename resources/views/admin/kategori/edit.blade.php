<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori Pertanyaan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('kategori-pertanyaan.update', $kategoriPertanyaan->id) }}"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama" class="block font-medium text-sm text-gray-700">
                            Nama Kategori
                        </label>
                        <input type="text" name="nama" id="nama"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200"
                            value="{{ old('nama', $kategoriPertanyaan->nama) }}" required>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('kategori-pertanyaan.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan
                            Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
