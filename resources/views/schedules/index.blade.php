{{-- @extends('layouts.app')

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
        </form> --}}

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
{{-- 
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
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Filter -->
                <form method="GET" action="{{ route('schedules.index') }}" class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <select name="doctor_id"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 
                                           dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                           focus:ring-blue-500 sm:text-sm">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="day"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 
                                           dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                           focus:ring-blue-500 sm:text-sm">
                                <option value="">-- Pilih Hari --</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Filter
                            </button>
                            <a href="{{ route('schedules.index') }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                @php
                    $grouped = $schedules->groupBy('doctor_id');
                    $counter = $schedules->firstItem();
                @endphp

                <!-- Tabel Jadwal -->
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2">#</th>
                            <th class="border px-4 py-2">Dokter</th>
                            <th class="border px-4 py-2">Hari</th>
                            <th class="border px-4 py-2">Jam Mulai</th>
                            <th class="border px-4 py-2">Jam Selesai</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grouped as $doctorSchedules)
                            @php $dokter = $doctorSchedules->first()->doctor; @endphp
                            <tr>
                                <td rowspan="{{ $doctorSchedules->count() }}" class="border px-4 py-2">
                                    {{ $counter++ }}</td>
                                <td rowspan="{{ $doctorSchedules->count() }}" class="border px-4 py-2">
                                    {{ $dokter->name }}</td>
                                <td class="border px-4 py-2">{{ $doctorSchedules[0]->day }}</td>
                                <td class="border px-4 py-2">{{ $doctorSchedules[0]->start_time }}</td>
                                <td class="border px-4 py-2">{{ $doctorSchedules[0]->end_time }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('schedules.show', $doctorSchedules[0]->id) }}"
                                        class="text-blue-500 hover:underline">Detail</a>
                                    <a href="{{ route('schedules.edit', $doctorSchedules[0]->id) }}"
                                        class="text-yellow-500 hover:underline ml-2">Edit</a>
                                    <form action="{{ route('schedules.destroy', $doctorSchedules[0]->id) }}"
                                        method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2"
                                            onclick="return confirm('Yakin hapus jadwal ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @foreach ($doctorSchedules->skip(1) as $schedule)
                                <tr>
                                    <td class="border px-4 py-2">{{ $schedule->day }}</td>
                                    <td class="border px-4 py-2">{{ $schedule->start_time }}</td>
                                    <td class="border px-4 py-2">{{ $schedule->end_time }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('schedules.show', $schedule->id) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                        <a href="{{ route('schedules.edit', $schedule->id) }}"
                                            class="text-yellow-500 hover:underline ml-2">Edit</a>
                                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                            class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2"
                                                onclick="return confirm('Yakin hapus jadwal ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 italic">Tidak ada data jadwal</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $schedules->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
