{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Pasien</h2>

        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="gender" class="form-control">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <form action="{{ route('patients.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis
                            Kelamin</label>
                        <select id="gender" name="gender"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm">
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="birth_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                        <textarea id="address" name="address"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                         dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                         focus:ring-blue-500 sm:text-sm">{{ old('address') }}</textarea>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="phone"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Simpan
                        </button>
                        <a href="{{ route('patients.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
