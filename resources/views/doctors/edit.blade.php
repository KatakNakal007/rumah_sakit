{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Dokter</h2>

        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $doctor->name }}">
            </div>
            <div class="mb-3">
                <label>Spesialisasi</label>
                <input type="text" name="specialization" class="form-control" value="{{ $doctor->specialization }}">
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ $doctor->phone }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" id="name" name="name" value="{{ $doctor->name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Spesialisasi -->
                    <div>
                        <label for="specialization"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spesialisasi</label>
                        <input type="text" id="specialization" name="specialization"
                            value="{{ $doctor->specialization }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="phone"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ $doctor->phone }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Update
                        </button>
                        <a href="{{ route('doctors.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
