{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Pasien</h2>
        <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Tambah Pasien</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('patients.index') }}" method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari nama pasien..."
                        value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <input type="date" name="birth_date" class="form-control" value="{{ request('birth_date') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100" type="submit">Filter</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->gender }}</td>
                        <td>{{ $patient->birth_date }}</td>
                        <td>{{ $patient->address }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>
                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $patients->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Tombol tambah pasien -->
                <a href="{{ route('patients.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-3 inline-block">
                    Tambah Pasien
                </a>

                <!-- Pesan sukses -->
                @if (session('success'))
                    <div class="bg-green-500 text-white p-2 rounded mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form filter -->
                <form action="{{ route('patients.index') }}" method="GET" class="mb-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <div>
                            <input type="text" name="keyword" placeholder="Cari nama pasien..."
                                value="{{ request('keyword') }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 
                                          dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                          focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <input type="date" name="birth_date" value="{{ request('birth_date') }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 
                                          dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                          focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Tabel pasien -->
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Jenis Kelamin</th>
                            <th class="border px-4 py-2">Tanggal Lahir</th>
                            <th class="border px-4 py-2">Alamat</th>
                            <th class="border px-4 py-2">Telepon</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td class="border px-4 py-2">{{ $patient->name }}</td>
                                <td class="border px-4 py-2">{{ $patient->gender }}</td>
                                <td class="border px-4 py-2">{{ $patient->birth_date }}</td>
                                <td class="border px-4 py-2">{{ $patient->address }}</td>
                                <td class="border px-4 py-2">{{ $patient->phone }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('patients.edit', $patient->id) }}"
                                        class="text-yellow-500 hover:underline">Edit</a>
                                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
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

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $patients->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
