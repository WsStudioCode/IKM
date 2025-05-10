<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pengaduan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

                <form method="POST" action="{{ route('pengaduan.update', $pengaduan->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Masyarakat</label>
                        <input type="text" value="{{ $pengaduan->masyarakat->nama }}"
                            class="block w-full rounded-md shadow-sm border-gray-300 bg-gray-100" disabled>
                        <input type="hidden" name="masyarakat_id" value="{{ $pengaduan->masyarakat_id }}">
                    </div>


                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Isi Pengaduan</label>
                        <textarea rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 bg-gray-100" disabled>{{ $pengaduan->isi }}</textarea>
                        <input type="hidden" name="isi" value="{{ $pengaduan->isi }}">
                    </div>


                    <div class="mb-4">
                        <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200">
                            <option value="Menunggu"
                                {{ old('status', $pengaduan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="Diproses"
                                {{ old('status', $pengaduan->status) == 'Diproses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="Selesai"
                                {{ old('status', $pengaduan->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="tanggapan" class="block font-medium text-sm text-gray-700">Tanggapan Admin</label>
                        <textarea name="tanggapan" id="tanggapan" rows="3"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200">{{ old('tanggapan', $pengaduan->tindakLanjut->tanggapan ?? '') }}</textarea>
                    </div>


                    <div class="flex justify-end">
                        <a href="{{ route('pengaduan.index') }}"
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
