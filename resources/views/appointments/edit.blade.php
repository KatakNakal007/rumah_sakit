@extends('layouts.app')

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
@endsection
