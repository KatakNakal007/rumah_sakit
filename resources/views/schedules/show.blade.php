{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Detail Jadwal Dokter</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5>Dokter: <strong>{{ $schedule->doctor->name }}</strong></h5>
                <p>Spesialis: {{ $schedule->doctor->specialization }}</p>
                <p>Hari: <strong>{{ $schedule->day }}</strong></p>
                <p>Jam Praktik: {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
            </div>
        </div>

        <h4>Janji Temu dalam Jadwal Ini</h4>
        @if ($appointments->count())
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $index => $appointment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->appointment_date ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $appointment->status === 'menunggu'
                                        ? 'warning'
                                        : ($appointment->status === 'diproses'
                                            ? 'primary'
                                            : ($appointment->status === 'selesai'
                                                ? 'success'
                                                : 'danger')) }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Belum ada janji temu dalam jadwal ini.</p>
        @endif

        <a href="{{ route('schedules.index') }}" class="btn btn-secondary mt-3">Kembali ke Jadwal</a>
    </div>
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Informasi Jadwal -->
                <h5 class="text-lg font-bold mb-2">Dokter: <span
                        class="font-semibold">{{ $schedule->doctor->name }}</span></h5>
                <p><span class="font-semibold">Spesialis:</span> {{ $schedule->doctor->specialization }}</p>
                <p><span class="font-semibold">Hari:</span> {{ $schedule->day }}</p>
                <p><span class="font-semibold">Jam Praktik:</span> {{ $schedule->start_time }} -
                    {{ $schedule->end_time }}</p>

                <!-- Tombol kembali -->
                <a href="{{ route('schedules.index') }}"
                    class="inline-block mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Kembali ke Jadwal
                </a>
            </div>

            <!-- Janji Temu -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mt-6 text-gray-900 dark:text-gray-100">
                <h4 class="text-md font-semibold mb-3">Janji Temu dalam Jadwal Ini</h4>

                @if ($appointments->count())
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Pasien</th>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $index => $appointment)
                                <tr>
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->patient->name }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->appointment_date ?? '-' }}</td>
                                    <td class="border px-4 py-2">
                                        @php
                                            $statusColors = [
                                                'menunggu' => 'bg-yellow-500 text-white',
                                                'diproses' => 'bg-blue-500 text-white',
                                                'selesai' => 'bg-green-500 text-white',
                                                'batal' => 'bg-red-500 text-white',
                                            ];
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$appointment->status] ?? 'bg-gray-500 text-white' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500 italic">Belum ada janji temu dalam jadwal ini.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
