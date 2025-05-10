<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Forum Diskusi: {{ $pengaduan->masyarakat->nama }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

        {{-- Pengaduan Utama --}}
        <div class="bg-white shadow p-6 rounded-lg border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Pengaduan Masyarakat</h3>
            <p class="text-gray-600">{{ $pengaduan->isi }}</p>

            <div class="mt-4 text-sm text-gray-500">
                Status: <strong>{{ $pengaduan->status }}</strong> |
                Tanggal: {{ $pengaduan->created_at->translatedFormat('d F Y H:i') }}
            </div>
        </div>

        {{-- Tindak Lanjut --}}
        @if ($pengaduan->tindakLanjut)
            <div class="bg-green-50 border border-green-300 text-green-800 p-6 rounded-lg">
                <h4 class="font-semibold text-md mb-2">Tanggapan Admin</h4>
                <p>{{ $pengaduan->tindakLanjut->tanggapan }}</p>
                <div class="mt-2 text-sm text-green-600">
                    Ditanggapi pada:
                    {{ $pengaduan->tindakLanjut->tanggal_tindak_lanjut->translatedFormat('d F Y H:i') }}
                </div>
            </div>
        @endif

        {{-- Komentar --}}
        <div class="bg-white shadow p-6 rounded-lg border border-gray-200">
            <h4 class="font-semibold mb-4">Komentar Masyarakat</h4>

            @forelse ($komentar as $komen)
                <div class="border-t pt-3 mt-3">
                    <p class="text-sm font-medium text-gray-800">{{ $komen->masyarakat->nama }}:</p>
                    <p class="text-gray-700">{{ $komen->isi }}</p>
                    <p class="text-xs text-gray-500">{{ $komen->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada komentar.</p>
            @endforelse

            <div class="mt-4">
                {{ $komentar->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
