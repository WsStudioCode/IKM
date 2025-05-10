<div class="overflow-x-auto">
    <table class="min-w-full text-sm text-left border border-gray-300">
        <thead class="bg-gray-100 text-xs uppercase font-semibold">
            <tr>
                <th class="px-4 py-2 border text-center">No</th>
                <th class="px-4 py-2 border text-center">Nama</th>
                <th class="px-4 py-2 border text-center">Nilai Rata-Rata</th>
                <th class="px-4 py-2 border text-center">Kategori</th>
                <th class="px-4 py-2 border text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hasilKuesioner as $index => $row)
                <tr>
                    <td class="px-4 py-2 border text-center">{{ $hasilKuesioner->firstItem() + $index }}</td>
                    <td class="px-4 py-2 border text-center">{{ $row->masyarakat->nama }}</td>
                    <td class="px-4 py-2 border text-center">{{ number_format($row->nilai_rata_rata, 2) }}</td>
                    <td class="px-4 py-2 border text-center">{{ $row->kategori_hasil }}</td>
                    <td class="px-4 py-2 border text-center">
                        {{ \Carbon\Carbon::parse($row->tanggal_isi)->translatedFormat('d F Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="mt-4">
    {{ $hasilKuesioner->withQueryString()->links() }}
</div>
