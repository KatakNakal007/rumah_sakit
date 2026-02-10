{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Janji Temu</h2>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">Buat Janji Temu</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($todayAppointments->count())
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <strong>Antrian Janji Temu Hari Ini ({{ \Carbon\Carbon::today()->format('d M Y') }})</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Spesialis</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todayAppointments as $appt)
                                <tr>
                                    <td>{{ $appt->patient->name }}</td>
                                    <td>{{ $appt->doctor->name }}</td>
                                    <td>{{ $appt->doctor->specialization }}</td>
                                    <td>{{ $appt->schedule->day }} ({{ $appt->schedule->start_time }} -
                                        {{ $appt->schedule->end_time }})</td>
                                    <td>
                                        @php
                                            $badge = match ($appt->status) {
                                                'menunggu' => 'warning',
                                                'dipanggil' => 'primary',
                                                'selesai' => 'success',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">{{ ucfirst($appt->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($antrianPerDokter->count())
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <strong>Total Antrian Hari Ini per Dokter</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Dokter</th>
                                <th>Spesialis</th>
                                <th>Total Antrian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($antrianPerDokter as $item)
                                <tr>
                                    <td>{{ $item->doctor->name }}</td>
                                    <td>{{ $item->doctor->specialization }}</td>
                                    <td><strong>{{ $item->total }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($appointments->isEmpty())
            <p class="text-muted">Belum ada janji temu.</p>
        @else
            <form method="GET" action="{{ route('appointments.index') }}" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="date" name="date" value="{{ $date }}" class="form-control"
                        placeholder="Tanggal">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="dipanggil" {{ $status == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                        <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="doctor_id" class="form-select">
                        <option value="">Semua Dokter</option>
                        @foreach ($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ $doctorId == $doc->id ? 'selected' : '' }}>
                                {{ $doc->name }} ({{ $doc->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
            <a href="{{ route('appointments.printToday') }}" class="btn btn-outline-info mb-3">
                Cetak Antrian Hari Ini
            </a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Spesialisasi</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->name ?? '-' }}</td>
                            <td>{{ $appointment->doctor->name ?? '-' }}</td>
                            <td>{{ $appointment->doctor->specialization ?? '-' }}</td>
                            <td>{{ $appointment->schedule->day ?? '-' }}</td>
                            <td>
                                {{ $appointment->schedule->start_time ?? '-' }} -
                                {{ $appointment->schedule->end_time ?? '-' }}
                            </td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>
                                @if ($appointment->queue)
                                    @if ($appointment->queue->called == 2)
                                        <span class="badge bg-success">Sudah Selesai Diperiksa</span>
                                    @elseif ($appointment->queue->called == 1)
                                        <span class="badge bg-primary">Sedang Dipanggil</span>
                                    @else
                                        <span class="badge bg-info">Sudah Masuk Antrian</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Belum Masuk Antrian</span>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('appointments.edit', $appointment->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus janji temu ini?')">
                                        Hapus
                                    </button>
                                </form>
                                <a href="{{ route('appointments.pdf', $appointment->id) }}"
                                    class="btn btn-sm btn-info">Cetak PDF</a>
                            </td>
                        </tr>
                    @endforeach

                    <div class="chart-wrapper">
                        <canvas id="grafikDokter" width="600" height="400"></canvas>
                        <canvas id="grafikStatus" width="600" height="400" class="mt-4"></canvas>
                    </div>

                    <button onclick="exportGabungan()" class="btn btn-success mt-3">Export Grafik Gabungan ke PDF</button>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const dokterChart = new Chart(document.getElementById('grafikDokter'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($labels) !!},
                                datasets: [{
                                    label: 'Jumlah Janji Temu',
                                    data: {!! json_encode($data) !!},
                                    backgroundColor: '#4faaf0'
                                }]
                            }
                        });

                        const statusChart = new Chart(document.getElementById('grafikStatus'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode(array_keys($statusCounts->toArray())) !!},
                                datasets: [{
                                    label: 'Distribusi Status',
                                    data: {!! json_encode(array_values($statusCounts->toArray())) !!},
                                    backgroundColor: '#f4af40'
                                }]
                            }
                        });

                        function exportGabungan() {
                            const img1 = document.getElementById('grafikDokter').toDataURL('image/png');
                            const img2 = document.getElementById('grafikStatus').toDataURL('image/png');

                            fetch("{{ route('appointments.exportCombinedChart') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        grafikDokter: img1,
                                        grafikStatus: img2
                                    })
                                })
                                .then(res => res.blob())
                                .then(blob => {
                                    const url = window.URL.createObjectURL(blob);
                                    const a = document.createElement('a');
                                    a.href = url;
                                    a.download = "grafik-gabungan.pdf";
                                    a.click();
                                });
                        }
                    </script>

                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $appointments->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Janji Temu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Tombol buat janji temu -->
                <a href="{{ route('appointments.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-3 inline-block">
                    Buat Janji Temu
                </a>

                <!-- Pesan sukses -->
                @if (session('success'))
                    <div class="bg-green-500 text-white p-2 rounded mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Antrian hari ini -->
                @if ($todayAppointments->count())
                    <div class="mb-6">
                        <div class="bg-blue-500 text-white px-4 py-2 rounded-t">
                            <strong>Antrian Janji Temu Hari Ini
                                ({{ \Carbon\Carbon::today()->format('d M Y') }})</strong>
                        </div>
                        <div class="border border-gray-300 rounded-b overflow-hidden">
                            <table class="table-auto w-full border-collapse">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="border px-4 py-2">Pasien</th>
                                        <th class="border px-4 py-2">Dokter</th>
                                        <th class="border px-4 py-2">Spesialis</th>
                                        <th class="border px-4 py-2">Jadwal</th>
                                        <th class="border px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayAppointments as $appt)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $appt->patient->name }}</td>
                                            <td class="border px-4 py-2">{{ $appt->doctor->name }}</td>
                                            <td class="border px-4 py-2">{{ $appt->doctor->specialization }}</td>
                                            <td class="border px-4 py-2">
                                                {{ $appt->schedule->day }} ({{ $appt->schedule->start_time }} -
                                                {{ $appt->schedule->end_time }})
                                            </td>
                                            <td class="border px-4 py-2">
                                                @php
                                                    $statusColors = [
                                                        'menunggu' => 'bg-yellow-500 text-white',
                                                        'dipanggil' => 'bg-blue-500 text-white',
                                                        'selesai' => 'bg-green-500 text-white',
                                                        'batal' => 'bg-red-500 text-white',
                                                    ];
                                                @endphp
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$appt->status] ?? 'bg-gray-500 text-white' }}">
                                                    {{ ucfirst($appt->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Total antrian per dokter -->
                @if ($antrianPerDokter->count())
                    <div class="mb-6">
                        <div class="bg-gray-600 text-white px-4 py-2 rounded-t">
                            <strong>Total Antrian Hari Ini per Dokter</strong>
                        </div>
                        <div class="border border-gray-300 rounded-b overflow-hidden">
                            <table class="table-auto w-full border-collapse">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="border px-4 py-2">Dokter</th>
                                        <th class="border px-4 py-2">Spesialis</th>
                                        <th class="border px-4 py-2">Total Antrian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($antrianPerDokter as $item)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $item->doctor->name }}</td>
                                            <td class="border px-4 py-2">{{ $item->doctor->specialization }}</td>
                                            <td class="border px-4 py-2 font-bold">{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Filter -->
                @if ($appointments->isEmpty())
                    <p class="text-gray-500 italic">Belum ada janji temu.</p>
                @else
                    <form method="GET" action="{{ route('appointments.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-3">
                        <div>
                            <input type="date" name="date" value="{{ $date }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 
                                          dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                          focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <select name="status"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 
                                           dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                           focus:ring-blue-500 sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="dipanggil" {{ $status == 'dipanggil' ? 'selected' : '' }}>Dipanggil
                                </option>
                                <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div>
                            <select name="doctor_id"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 
                                           dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 
                                           focus:ring-blue-500 sm:text-sm">
                                <option value="">Semua Dokter</option>
                                @foreach ($doctors as $doc)
                                    <option value="{{ $doc->id }}" {{ $doctorId == $doc->id ? 'selected' : '' }}>
                                        {{ $doc->name }} ({{ $doc->specialization }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Filter
                            </button>
                        </div>
                    </form>

                    <!-- Cetak antrian hari ini -->
                    <a href="{{ route('appointments.printToday') }}"
                        class="bg-blue-100 text-blue-600 px-4 py-2 rounded hover:bg-blue-200 inline-block mb-3">
                        Cetak Antrian Hari Ini
                    </a>
                    <!-- Tabel Janji Temu -->
                    <table class="table-auto w-full border-collapse border border-gray-300 mt-6">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2">Pasien</th>
                                <th class="border px-4 py-2">Dokter</th>
                                <th class="border px-4 py-2">Spesialisasi</th>
                                <th class="border px-4 py-2">Hari</th>
                                <th class="border px-4 py-2">Jam</th>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td class="border px-4 py-2">{{ $appointment->patient->name ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->doctor->name ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->doctor->specialization ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $appointment->schedule->day ?? '-' }}</td>
                                    <td class="border px-4 py-2">
                                        {{ $appointment->schedule->start_time ?? '-' }} -
                                        {{ $appointment->schedule->end_time ?? '-' }}
                                    </td>
                                    <td class="border px-4 py-2">{{ $appointment->appointment_date }}</td>
                                    <td class="border px-4 py-2">
                                        @if ($appointment->queue)
                                            @if ($appointment->queue->called == 2)
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold bg-green-500 text-white">
                                                    Sudah Selesai Diperiksa
                                                </span>
                                            @elseif ($appointment->queue->called == 1)
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold bg-blue-500 text-white">
                                                    Sedang Dipanggil
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold bg-yellow-500 text-white">
                                                    Sudah Masuk Antrian
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="px-2 py-1 rounded text-xs font-semibold bg-gray-500 text-white">
                                                Belum Masuk Antrian
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('appointments.edit', $appointment->id) }}"
                                            class="text-yellow-500 hover:underline">Edit</a>
                                        <form action="{{ route('appointments.destroy', $appointment->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2"
                                                onclick="return confirm('Yakin ingin menghapus janji temu ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                        <a href="{{ route('appointments.pdf', $appointment->id) }}"
                                            class="text-blue-500 hover:underline ml-2">Cetak PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Grafik Chart.js -->
                    <div class="mt-6">
                        <canvas id="grafikDokter" width="600" height="400"></canvas>
                        <canvas id="grafikStatus" width="600" height="400" class="mt-6"></canvas>
                    </div>

                    <button onclick="exportGabungan()"
                        class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Export Grafik Gabungan ke PDF
                    </button>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const dokterChart = new Chart(document.getElementById('grafikDokter'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($labels) !!},
                                datasets: [{
                                    label: 'Jumlah Janji Temu',
                                    data: {!! json_encode($data) !!},
                                    backgroundColor: '#4faaf0'
                                }]
                            }
                        });

                        const statusChart = new Chart(document.getElementById('grafikStatus'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode(array_keys($statusCounts->toArray())) !!},
                                datasets: [{
                                    label: 'Distribusi Status',
                                    data: {!! json_encode(array_values($statusCounts->toArray())) !!},
                                    backgroundColor: '#f4af40'
                                }]
                            }
                        });

                        function exportGabungan() {
                            const img1 = document.getElementById('grafikDokter').toDataURL('image/png');
                            const img2 = document.getElementById('grafikStatus').toDataURL('image/png');

                            fetch("{{ route('appointments.exportCombinedChart') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        grafikDokter: img1,
                                        grafikStatus: img2
                                    })
                                })
                                .then(res => res.blob())
                                .then(blob => {
                                    const url = window.URL.createObjectURL(blob);
                                    const a = document.createElement('a');
                                    a.href = url;
                                    a.download = "grafik-gabungan.pdf";
                                    a.click();
                                });
                        }
                    </script>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $appointments->links() }}
                    </div>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
