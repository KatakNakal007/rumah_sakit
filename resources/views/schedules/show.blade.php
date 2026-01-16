@extends('layouts.app')

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
@endsection
