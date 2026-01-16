@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Dokter</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $doctor->name }}</h5>
                <p><strong>Spesialisasi:</strong> {{ $doctor->specialization }}</p>
                <p><strong>Telepon:</strong> {{ $doctor->phone }}</p>
            </div>
        </div>

        <h4>Jadwal Praktik</h4>

        @if ($doctor->schedules->isEmpty())
            <p class="text-muted">Belum ada jadwal praktik.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctor->schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('doctors.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
