{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Dokter</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $doctor->name }}</h5>
                <p><strong>Spesialisasi:</strong> {{ $doctor->specialization }}</p>
                <p><strong>Telepon:</strong> {{ $doctor->phone }}</p>
            </div>
        </div>

        <h4>Jadwal Praktik</h4>

        @if ($doctor->schedules->isEmpty())
            <p class="text-muted">Belum ada jadwal praktik.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctor->schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('doctors.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection --}}


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Informasi Dokter -->
                <h3 class="text-lg font-bold mb-4">{{ $doctor->name }}</h3>
                <p><span class="font-semibold">Spesialisasi:</span> {{ $doctor->specialization }}</p>
                <p><span class="font-semibold">Telepon:</span> {{ $doctor->phone }}</p>

                <!-- Jadwal Praktik -->
                <h4 class="text-md font-semibold mt-6 mb-2">Jadwal Praktik</h4>

                @if ($doctor->schedules->isEmpty())
                    <p class="text-gray-500 italic">Belum ada jadwal praktik.</p>
                @else
                    <table class="table-auto w-full border-collapse border border-gray-300 mt-3">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2">Hari</th>
                                <th class="border px-4 py-2">Jam Mulai</th>
                                <th class="border px-4 py-2">Jam Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctor->schedules as $schedule)
                                <tr>
                                    <td class="border px-4 py-2">{{ $schedule->day }}</td>
                                    <td class="border px-4 py-2">{{ $schedule->start_time }}</td>
                                    <td class="border px-4 py-2">{{ $schedule->end_time }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <!-- Tombol Kembali -->
                <a href="{{ route('doctors.index') }}"
                    class="inline-block mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
