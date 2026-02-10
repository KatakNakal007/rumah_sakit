{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Pasien</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $patient->name }}</h5>
                <p><strong>Jenis Kelamin:</strong> {{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                <p><strong>Tanggal Lahir:</strong> {{ $patient->birth_date }}</p>
                <p><strong>Alamat:</strong> {{ $patient->address }}</p>
                <p><strong>Telepon:</strong> {{ $patient->phone }}</p>
            </div>
        </div>

        <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>

    <h4 class="mt-4">Riwayat Janji Temu</h4>

    @if ($patient->appointments->isEmpty())
        <p class="text-muted">Belum ada janji temu.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Spesialisasi</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patient->appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->doctor->name ?? '-' }}</td>
                        <td>{{ $appointment->doctor->specialization ?? '-' }}</td>
                        <td>{{ $appointment->schedule->day ?? '-' }}</td>
                        <td>
                            {{ $appointment->schedule->start_time ?? '-' }} -
                            {{ $appointment->schedule->end_time ?? '-' }}
                        </td>
                        <td>{{ ucfirst($appointment->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Informasi Pasien -->
                <h3 class="text-lg font-bold mb-4">{{ $patient->name }}</h3>
                <p><span class="font-semibold">Jenis Kelamin:</span>
                    {{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                <p><span class="font-semibold">Tanggal Lahir:</span> {{ $patient->birth_date }}</p>
                <p><span class="font-semibold">Alamat:</span> {{ $patient->address }}</p>
                <p><span class="font-semibold">Telepon:</span> {{ $patient->phone }}</p>

                <!-- Tombol kembali -->
                <a href="{{ route('patients.index') }}"
                    class="inline-block mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Kembali
                </a>
            </div>

            <!-- Riwayat Janji Temu -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mt-6 text-gray-900 dark:text-gray-100">
                <h4 class="text-md font-semibold mb-3">Riwayat Janji Temu</h4>

                @if ($patient->appointments->isEmpty())
                    <p class="text-gray-500 italic">Belum ada janji temu.</p>
                @else
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Dokter</th>
                                <th class="border px-4 py-2">Spesialisasi</th>
                                <th class="border px-4 py-2">Hari</th>
                                <th class="border px-4 py-2">Jam</th>
                                <th class="border px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->appointments as $appointment)
                                <tr>
                                    <td class="border px-4 py-2">{{ $appointment->appointment_date }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->doctor->name ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->doctor->specialization ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->schedule->day ?? '-' }}</td>
                                    <td class="border px-4 py-2">
                                        {{ $appointment->schedule->start_time ?? '-' }} -
                                        {{ $appointment->schedule->end_time ?? '-' }}
                                    </td>
                                    <td class="border px-4 py-2">{{ ucfirst($appointment->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
