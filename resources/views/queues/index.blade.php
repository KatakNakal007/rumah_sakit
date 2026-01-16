@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">📋 Daftar Antrian</h3>
        <a href="{{ route('queues.create') }}" class="btn btn-primary mb-3">
            Tambah Antrian
        </a>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Jadwal Praktik</th>
                    <th>Tanggal Janji Temu</th>
                    <th>Nomor Antrian</th>
                    <th colspan="2" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($queues as $queue)
                    <tr>
                        {{-- Nomor urut baris --}}
                        <td>{{ $loop->iteration }}</td>

                        {{-- Data dari relasi appointment --}}
                        <td>{{ $queue->appointment->patient->name }}</td>
                        <td>{{ $queue->appointment->doctor->name }} ({{ $queue->appointment->doctor->specialization }})</td>
                        <td>{{ $queue->appointment->schedule->day }} ({{ $queue->appointment->schedule->start_time }} -
                            {{ $queue->appointment->schedule->end_time }})</td>
                        <td>{{ \Carbon\Carbon::parse($queue->appointment->appointment_date)->format('d/m/Y') }}</td>

                        {{-- Nomor antrian dari tabel queues --}}
                        <td>
                            @if ($queue->called == 2)
                                <span class="text-muted">—</span>
                            @else
                                {{ $queue->queue_number }}
                            @endif
                        </td>

                        {{-- Status dipanggil/menunggu --}}
                        <td>
                            @if ($queue->called == 0)
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif ($queue->called == 1)
                                <span class="badge bg-primary">Dipanggil</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif

                        </td>
                        <td>
                            @if ($queue->called == 0)
                                <form action="{{ route('queues.call', $queue->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">Panggil</button>
                                </form>
                            @elseif ($queue->called == 1)
                                <form action="{{ route('queues.finish', $queue->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Selesai</button>
                                </form>
                            @else
                                <span class="text-muted">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada antrian</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
