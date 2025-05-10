<div class="flex justify-center space-x-2">
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
