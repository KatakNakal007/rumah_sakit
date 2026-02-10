{{-- @extends('layouts.app')

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

                        <td>{{ $loop->iteration }}</td>


                        <td>{{ $queue->appointment->patient->name }}</td>
                        <td>{{ $queue->appointment->doctor->name }} ({{ $queue->appointment->doctor->specialization }})</td>
                        <td>{{ $queue->appointment->schedule->day }} ({{ $queue->appointment->schedule->start_time }} -
                            {{ $queue->appointment->schedule->end_time }})</td>
                        <td>{{ \Carbon\Carbon::parse($queue->appointment->appointment_date)->format('d/m/Y') }}</td>


                        <td>
                            @if ($queue->called == 2)
                                <span class="text-muted">—</span>
                            @else
                                {{ $queue->queue_number }}
                            @endif
                        </td>


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
@endsection --}}
<x-app-layout>
    <x-slot name="header">
        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📋 Daftar Antrian
        </h3>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Tombol tambah antrian -->
                <a href="{{ route('queues.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-3 inline-block">
                    Tambah Antrian
                </a>

                <!-- Tabel antrian -->
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Pasien</th>
                            <th class="border px-4 py-2">Dokter</th>
                            <th class="border px-4 py-2">Jadwal Praktik</th>
                            <th class="border px-4 py-2">Tanggal Janji Temu</th>
                            <th class="border px-4 py-2">Nomor Antrian</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queues as $queue)
                            <tr>
                                <!-- Nomor urut baris -->
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>

                                <!-- Data dari relasi appointment -->
                                <td class="border px-4 py-2">{{ $queue->appointment->patient->name }}</td>
                                <td class="border px-4 py-2">
                                    {{ $queue->appointment->doctor->name }}
                                    ({{ $queue->appointment->doctor->specialization }})
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $queue->appointment->schedule->day }}
                                    ({{ $queue->appointment->schedule->start_time }} -
                                    {{ $queue->appointment->schedule->end_time }})
                                </td>
                                <td class="border px-4 py-2">
                                    {{ \Carbon\Carbon::parse($queue->appointment->appointment_date)->format('d/m/Y') }}
                                </td>

                                <!-- Nomor antrian -->
                                <td class="border px-4 py-2">
                                    @if ($queue->called == 2)
                                        <span class="text-gray-400">—</span>
                                    @else
                                        {{ $queue->queue_number }}
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="border px-4 py-2">
                                    @if ($queue->called == 0)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold bg-yellow-500 text-white">Menunggu</span>
                                    @elseif ($queue->called == 1)
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold bg-blue-500 text-white">Dipanggil</span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold bg-green-500 text-white">Selesai</span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="border px-4 py-2">
                                    @if ($queue->called == 0)
                                        <form action="{{ route('queues.call', $queue->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                                Panggil
                                            </button>
                                        </form>
                                    @elseif ($queue->called == 1)
                                        <form action="{{ route('queues.finish', $queue->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                                Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-500 italic">Belum ada antrian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
