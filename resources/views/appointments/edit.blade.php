{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Janji Temu</h2>

        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Pasien</label>
                <select name="patient_id" class="form-control" required>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Dokter</label>
                <select name="doctor_id" class="form-control" required>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} ({{ $doctor->specialization }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Jadwal Praktik</label>
                <select name="schedule_id" class="form-control" required>
                    @foreach ($doctors as $doctor)
                        @foreach ($doctor->schedules as $schedule)
                            <option value="{{ $schedule->id }}"
                                {{ $appointment->schedule_id == $schedule->id ? 'selected' : '' }}>
                                {{ $doctor->name }} - {{ $schedule->day }} ({{ $schedule->start_time }} -
                                {{ $schedule->end_time }})
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Janji Temu</label>
                <input type="date" name="appointment_date" class="form-control"
                    value="{{ $appointment->appointment_date }}" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="menunggu" {{ $appointment->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ $appointment->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $appointment->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ $appointment->status == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Janji Temu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Pasien -->
                    <div>
                        <label for="patient_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pasien</label>
                        <select id="patient_id" name="patient_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm">
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dokter -->
                    <div>
                        <label for="doctor_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dokter</label>
                        <select id="doctor_id" name="doctor_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm">
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jadwal Praktik -->
                    <div>
                        <label for="schedule_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jadwal Praktik</label>
                        <select id="schedule_id" name="schedule_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm">
                            @foreach ($doctors as $doctor)
                                @foreach ($doctor->schedules as $schedule)
                                    <option value="{{ $schedule->id }}"
                                        {{ $appointment->schedule_id == $schedule->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} - {{ $schedule->day }} ({{ $schedule->start_time }} -
                                        {{ $schedule->end_time }})
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Janji Temu -->
                    <div>
                        <label for="appointment_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Janji
                            Temu</label>
                        <input type="date" id="appointment_date" name="appointment_date" required
                            value="{{ $appointment->appointment_date }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm">
                            <option value="menunggu" {{ $appointment->status == 'menunggu' ? 'selected' : '' }}>
                                Menunggu</option>
                            <option value="diproses" {{ $appointment->status == 'diproses' ? 'selected' : '' }}>
                                Diproses</option>
                            <option value="selesai" {{ $appointment->status == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="batal" {{ $appointment->status == 'batal' ? 'selected' : '' }}>Batal
                            </option>
                        </select>
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Update
                        </button>
                        <a href="{{ route('appointments.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
