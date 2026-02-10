{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Pasien</h2>

        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $patient->name }}">
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="gender" class="form-control">
                    <option value="L" {{ $patient->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $patient->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control" value="{{ $patient->birth_date }}">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="address" class="form-control">{{ $patient->address }}</textarea>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ $patient->phone }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" id="name" name="name" value="{{ $patient->name }}"
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
                            <option value="L" {{ $patient->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $patient->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="birth_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ $patient->birth_date }}"
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
                                         focus:ring-blue-500 sm:text-sm">{{ $patient->address }}</textarea>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="phone"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ $patient->phone }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Update
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
