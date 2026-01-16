@extends('layouts.app')

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
@endsection
