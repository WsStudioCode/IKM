<div class="flex justify-center space-x-2">
    {{-- Tombol Detail --}}
    <a href="{{ route('pengaduan.show', $row->id) }}" title="Detail" class="text-blue-600 hover:text-blue-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </a>

    {{-- Tombol Edit --}}
    <a href="{{ route('pengaduan.edit', $row->id) }}" title="Edit" class="text-indigo-600 hover:text-indigo-900">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M17.414 2.586a2 2 0 010 2.828L8.828 14H6v-2.828l8.586-8.586a2 2 0 012.828 0z" />
            <path fill-rule="evenodd" d="M4 16a2 2 0 002 2h10a2 2 0 002-2v-5.586a1 1 0 10-2 0V16H6v-2a1 1 0 10-2 0v2z"
                clip-rule="evenodd" />
        </svg>
    </a>

    {{-- Tombol Hapus --}}
    <form method="POST" action="{{ route('pengaduan.destroy', $row->id) }}"
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
