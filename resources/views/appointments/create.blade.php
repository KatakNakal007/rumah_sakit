{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Buat Janji Temu</h2>

        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Pasien</label>
                <select name="patient_id" class="form-control" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Dokter</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Jadwal Praktik</label>
                <select name="schedule_id" id="schedule_id" class="form-control" required disabled>
                    <option value="">-- Pilih Jadwal --</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Janji Temu</label>
                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required disabled
                    min="{{ \Carbon\Carbon::today()->toDateString() }}" onkeydown="return false" onpaste="return false">
                @error('appointment_date')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Status</label>
                <input type="hidden" name="status" value="menunggu">
                <input type="text" class="form-control" value="Menunggu" readonly>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        // field jadwal praktik
        document.getElementById('doctor_id').addEventListener('change', function() {
            const doctorId = this.value;
            const scheduleSelect = document.getElementById('schedule_id');
            scheduleSelect.innerHTML = '<option value="">-- Pilih Jadwal --</option>';
            scheduleSelect.disabled = true; // default: tetap tertutup

            if (doctorId) {
                fetch(`/schedules/by-doctor/${doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(schedule => {
                            const option = document.createElement('option');
                            option.value = schedule.id;
                            option.text =
                                `${schedule.day} (${schedule.start_time} - ${schedule.end_time})`;
                            scheduleSelect.appendChild(option);
                        });
                        scheduleSelect.disabled = false; // aktifkan setelah data masuk
                    });
            }
        });

        // field pilih tanggal 
        document.getElementById('schedule_id').addEventListener('change', function() {
            const appointmentDate = document.getElementById('appointment_date');

            if (this.value) {
                // jika jadwal praktik dipilih, aktifkan field tanggal
                appointmentDate.disabled = false;
            } else {
                // jika jadwal dikosongkan, disable lagi
                appointmentDate.disabled = true;
                appointmentDate.value = '';
            }
        });
    </script>
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Janji Temu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <form action="{{ route('appointments.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Pasien -->
                    <div>
                        <label for="patient_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pasien</label>
                        <select id="patient_id" name="patient_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
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
                            <option value="">-- Pilih Dokter --</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jadwal Praktik -->
                    <div>
                        <label for="schedule_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jadwal Praktik</label>
                        <select id="schedule_id" name="schedule_id" required disabled
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                       dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                       focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Pilih Jadwal --</option>
                        </select>
                    </div>

                    <!-- Tanggal Janji Temu -->
                    <div>
                        <label for="appointment_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Janji
                            Temu</label>
                        <input type="date" id="appointment_date" name="appointment_date" required disabled
                            min="{{ \Carbon\Carbon::today()->toDateString() }}" onkeydown="return false"
                            onpaste="return false"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                      focus:ring-blue-500 sm:text-sm">
                        @error('appointment_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <input type="hidden" name="status" value="menunggu">
                        <input type="text" value="Menunggu" readonly
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                      dark:bg-gray-700 dark:text-gray-100 shadow-sm sm:text-sm">
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Simpan
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

    <script>
        // field jadwal praktik
        document.getElementById('doctor_id').addEventListener('change', function() {
            const doctorId = this.value;
            const scheduleSelect = document.getElementById('schedule_id');
            scheduleSelect.innerHTML = '<option value="">-- Pilih Jadwal --</option>';
            scheduleSelect.disabled = true;

            if (doctorId) {
                fetch(`/schedules/by-doctor/${doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(schedule => {
                            const option = document.createElement('option');
                            option.value = schedule.id;
                            option.text =
                                `${schedule.day} (${schedule.start_time} - ${schedule.end_time})`;
                            scheduleSelect.appendChild(option);
                        });
                        scheduleSelect.disabled = false;
                    });
            }
        });

        // field pilih tanggal
        document.getElementById('schedule_id').addEventListener('change', function() {
            const appointmentDate = document.getElementById('appointment_date');
            if (this.value) {
                appointmentDate.disabled = false;
            } else {
                appointmentDate.disabled = true;
                appointmentDate.value = '';
            }
        });
    </script>
</x-app-layout>
