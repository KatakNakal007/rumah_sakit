@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Tambah Antrian Manual</h3>

        {{-- <form action="{{ route('queues.store') }}" method="POST">
            @csrf --}}

        {{-- Pilih Janji Temu --}}
        {{-- <div class="mb-3"> --}}
        {{-- <label for="appointment_id" class="form-label">Pilih Janji Temu</label>
                <select name="appointment_id" id="appointment_id"
                    class="form-select @error('appointment_id') is-invalid @enderror">
                    <option value="">-- Pilih Janji Temu --</option>
                    @foreach ($appointments as $appointment)
                        <option value="{{ $appointment->id }}"
                            {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                            {{ $appointment->patient->name }} - {{ $appointment->doctor->name }} -
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select> --}}
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

        {{-- </div> --}}

        {{-- Nomor Antrian --}}
        {{-- <div class="mb-3"> --}}
        @if ($selectedAppointmentId)
            <form method="POST" action="{{ route('queues.store') }}">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $selectedAppointmentId }}">
                <div class="mb-3">
                    <label for="queue_number">Nomor Antrian</label>
                    <input type="number" name="queue_number" id="queue_number" class="form-control" readonly
                        value="{{ old('queue_number', $nextQueueNumber) }}">
                    {{-- @error('queue_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror --}}
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
        {{-- </div> --}}
        {{-- </form> --}}
    </div>
@endsection
