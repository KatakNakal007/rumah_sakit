<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <a href="{{ route('doctors.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-3 inline-block">
                        Tambah Dokter
                    </a>

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-2 rounded mb-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Spesialisasi</th>
                                <th class="border px-4 py-2">Telepon</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td class="border px-4 py-2">{{ $doctor->name }}</td>
                                    <td class="border px-4 py-2">{{ $doctor->specialization }}</td>
                                    <td class="border px-4 py-2">{{ $doctor->phone }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('doctors.edit', $doctor->id) }}"
                                            class="text-yellow-500 hover:underline">Edit</a>
                                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2"
                                                onclick="return confirm('Yakin hapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
