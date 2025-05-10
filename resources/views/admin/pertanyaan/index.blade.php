<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pertanyaan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('pertanyaan.create') }}"
                class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Tambah Pertanyaan
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    {!! $dataTable->table(
                        ['class' => 'cell-border w-full min-w-max table table-bordered table-striped whitespace-nowrap'],
                        true,
                    ) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Push scripts to bottom --}}
    @push('scripts')
        {!! $dataTable->scripts() !!}
    @endpush
</x-app-layout>
