<div class="flex justify-center space-x-2">
    {{-- Tombol Detail (Ikon Mata) --}}
    <a href="{{ route('hasil-kuesioner.show', $row->id) }}" title="Lihat Detail"
        class="text-blue-600 hover:text-blue-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zM10 15a5 5 0 110-10 5 5 0 010 10z" />
            <path d="M10 7a3 3 0 100 6 3 3 0 000-6z" />
        </svg>
    </a>

    {{-- Tombol Hapus --}}
    <form method="POST" action="{{ route('masyarakat.destroy', $row->id) }}"
        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" title="Hapus" class="text-red-600 hover:text-red-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M6 8a1 1 0 00-1 1v7a1 1 0 001 1h8a1 1 0 001-1V9a1 1 0 00-1-1H6zm2 2a1 1 0 012 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 012 0v5a1 1 0 11-2 0v-5zM4 5a1 1 0 011-1h10a1 1 0 011 1v1H4V5z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </form>
</div>
