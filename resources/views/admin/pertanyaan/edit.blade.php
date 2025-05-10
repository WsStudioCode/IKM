<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pertanyaan') }}
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

                <form method="POST" action="{{ route('pertanyaan.update', $pertanyaan->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="isi_pertanyaan" class="block font-medium text-sm text-gray-700">Isi
                            Pertanyaan</label>
                        <textarea name="isi_pertanyaan" id="isi_pertanyaan" rows="4" required
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200">{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="kategori_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                        <select name="kategori_id" id="kategori_id"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id', $pertanyaan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="flex justify-end">
                        <a href="{{ route('pertanyaan.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</a>
                        <button type="submit"
                            class="ml-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan
                            Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
