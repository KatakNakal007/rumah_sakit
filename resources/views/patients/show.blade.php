@extends('layouts.app')

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
@endsection
