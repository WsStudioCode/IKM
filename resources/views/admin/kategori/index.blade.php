<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori Pertanyaan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('kategori-pertanyaan.create') }}"
                class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Tambah Kategori Pertanyaan
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    {!! $dataTable->table(['class' => 'cell-border min-w-full table-auto whitespace-nowrap'], true) !!}
                </div>

            </div>
        </div>
    </div>

    {{-- Push scripts to bottom --}}
    @push('scripts')
        {!! $dataTable->scripts() !!}
    @endpush
</x-app-layout>
