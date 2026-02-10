{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Tambah Antrian Manual</h3>

        <form method="GET" action="{{ route('queues.create') }}">
            <div class="mb-3">
                <label for="appointment_id">Pilih Janji Temu</label>
                <select name="appointment_id" id="appointment_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Janji Temu --</option>
                    @foreach ($appointments as $appointment)
                        <option value="{{ $appointment->id }}"
                            {{ $selectedAppointmentId == $appointment->id ? 'selected' : '' }}>
                            {{ $appointment->patient->name }} - {{ $appointment->doctor->name }} -
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select>

                @error('appointment_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </form>

        @if ($selectedAppointmentId)
            <form method="POST" action="{{ route('queues.store') }}">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $selectedAppointmentId }}">
                <div class="mb-3">
                    <label for="queue_number">Nomor Antrian</label>
                    <input type="number" name="queue_number" id="queue_number" class="form-control" readonly
                        value="{{ old('queue_number', $nextQueueNumber) }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('queues.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        @endif

        @if ($appointment)
            <p><strong>Debug:</strong> Dokter ID = {{ $appointment->doctor_id }},
                Tanggal = {{ \Carbon\Carbon::parse($appointment->appointment_date)->toDateString() }},
                Nomor berikutnya = {{ $nextQueueNumber }}</p>
        @endif
    </div>
@endsection --}}
<x-app-layout>
    <x-slot name="header">
        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Antrian Manual
        </h3>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Pilih Janji Temu -->
                <form method="GET" action="{{ route('queues.create') }}" class="space-y-4">
                    <div>
                        <label for="appointment_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pilih Janji Temu
                        </label>
                        <select name="appointment_id" id="appointment_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm"
                            onchange="this.form.submit()">
                            <option value="">-- Pilih Janji Temu --</option>
                            @foreach ($appointments as $appointment)
                                <option value="{{ $appointment->id }}"
                                    {{ $selectedAppointmentId == $appointment->id ? 'selected' : '' }}>
                                    {{ $appointment->patient->name }} - {{ $appointment->doctor->name }} -
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </form>

                <!-- Nomor Antrian -->
                @if ($selectedAppointmentId)
                    <form method="POST" action="{{ route('queues.store') }}" class="space-y-4 mt-6">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $selectedAppointmentId }}">

                        <div>
                            <label for="queue_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nomor Antrian
                            </label>
                            <input type="number" id="queue_number" name="queue_number"
                                value="{{ old('queue_number', $nextQueueNumber) }}" readonly
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                          dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                          focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div class="flex items-center space-x-3">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Simpan
                            </button>
                            <a href="{{ route('queues.index') }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Kembali
                            </a>
                        </div>
                    </form>
                @endif

                <!-- Debug Info (opsional, bisa dihapus di production) -->
                @if ($appointment)
                    <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                        <strong>Debug:</strong> Dokter ID = {{ $appointment->doctor_id }},
                        Tanggal = {{ \Carbon\Carbon::parse($appointment->appointment_date)->toDateString() }},
                        Nomor berikutnya = {{ $nextQueueNumber }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
