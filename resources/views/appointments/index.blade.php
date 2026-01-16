@extends('layouts.app')

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
            {{-- <form action="{{ route('appointments.index') }}" method="GET" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-primary w-100" type="submit">Filter</button>
                    </div>
                </div>
            </form> --}}
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
                            {{-- <td>{{ ucfirst($appointment->status) }}</td> --}}
                            {{-- <td>
                                @php
                                    $status = $appointment->status;
                                    $badgeClass = match ($status) {
                                        'menunggu' => 'warning',
                                        'selesai' => 'success',
                                        'batal' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge bg-{{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td> --}}
                            <td>
                                {{-- <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                                    @csrf @method('PUT')

                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="menunggu"
                                            {{ $appointment->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="dipanggil"
                                            {{ $appointment->status == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                                        <option value="selesai" {{ $appointment->status == 'selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                    </select>
                                </form> --}}
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
                    {{-- <canvas id="grafikJanjiTemu"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const ctx = document.getElementById('grafikJanjiTemu').getContext('2d');
                        const chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($dailyCounts->pluck('date')) !!},
                                datasets: [{
                                    label: 'Jumlah Janji Temu',
                                    data: {!! json_encode($dailyCounts->pluck('total')) !!},
                                    backgroundColor: '#4faaf0'
                                }]
                            }
                        });
                    </script> --}}
                    {{-- <canvas id="grafikPerDokter"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const ctx = document.getElementById('grafikPerDokter').getContext('2d');
                        const chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($perDokterChart->pluck('doctor.name')) !!},
                                datasets: [{
                                    label: 'Jumlah Janji Temu',
                                    data: {!! json_encode($perDokterChart->pluck('total')) !!},
                                    backgroundColor: '#4faaf0'
                                }]
                            }
                        });
                    </script> --}}

                    {{-- <canvas id="grafikDokter" width="600" height="400"></canvas>

                    <button onclick="exportToPdf()" class="btn btn-primary mt-3">Export Grafik ke PDF</button>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const ctx = document.getElementById('grafikDokter').getContext('2d');
                        const chart = new Chart(ctx, {
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

                        function exportToPdf() {
                            const canvas = document.getElementById('grafikDokter');
                            const imageData = canvas.toDataURL('image/png');

                            fetch("{{ route('appointments.exportChartImage') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        image: imageData
                                    })
                                })
                                .then(response => response.blob())
                                .then(blob => {
                                    const url = window.URL.createObjectURL(blob);
                                    const a = document.createElement('a');
                                    a.href = url;
                                    a.download = "grafik-janji-temu.pdf";
                                    a.click();
                                });
                        }
                    </script> --}}

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

                    {{-- <canvas id="grafikDokter"></canvas>
                    <canvas id="grafikStatus" class="mt-5"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        new Chart(document.getElementById('grafikDokter'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($perDokter->pluck('doctor.name')) !!},
                                datasets: [{
                                    label: 'Jumlah Janji Temu',
                                    data: {!! json_encode($perDokter->pluck('total')) !!},
                                    backgroundColor: '#4faaf0'
                                }]
                            }
                        });

                        new Chart(document.getElementById('grafikStatus'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($statusCounts->keys()) !!},
                                datasets: [{
                                    label: 'Distribusi Status',
                                    data: {!! json_encode($statusCounts->values()) !!},
                                    backgroundColor: '#f4af40'
                                }]
                            }
                        });
                    </script> --}}
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $appointments->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
