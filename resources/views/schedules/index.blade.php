@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Daftar Jadwal Dokter</h2>

        <!-- Filter -->
        <form method="GET" action="{{ route('schedules.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="doctor_id" class="form-control">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="day" class="form-control">
                        <option value="">-- Pilih Hari --</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                            <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- <!-- Tabel Jadwal -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Dokter</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $index => $schedule)
                    <tr>
                        <td>{{ $schedules->firstItem() + $index }}</td>
                        <td>{{ $schedule->doctor->name }}</td>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ $schedule->start_time }}</td>
                        <td>{{ $schedule->end_time }}</td>
                        <td>
                            <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data jadwal</td>
                    </tr>
                @endforelse
            </tbody>
        </table> --}}

        @php
            $grouped = $schedules->groupBy('doctor_id');
            $counter = $schedules->firstItem();
        @endphp

        <!-- Tabel Jadwal -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Dokter</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grouped as $doctorSchedules)
                    @php $dokter = $doctorSchedules->first()->doctor; @endphp
                    <tr>
                        <td rowspan="{{ $doctorSchedules->count() }}">{{ $counter++ }}</td>
                        <td rowspan="{{ $doctorSchedules->count() }}">{{ $dokter->name }}</td>
                        <td>{{ $doctorSchedules[0]->day }}</td>
                        <td>{{ $doctorSchedules[0]->start_time }}</td>
                        <td>{{ $doctorSchedules[0]->end_time }}</td>
                        <td>
                            <a href="{{ route('schedules.show', $doctorSchedules[0]->id) }}"
                                class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('schedules.edit', $doctorSchedules[0]->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('schedules.destroy', $doctorSchedules[0]->id) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @foreach ($doctorSchedules->skip(1) as $schedule)
                        <tr>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                            <td>
                                <a href="{{ route('schedules.show', $schedule->id) }}"
                                    class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('schedules.edit', $schedule->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data jadwal</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $schedules->links() }}
        </div>
    </div>
@endsection
