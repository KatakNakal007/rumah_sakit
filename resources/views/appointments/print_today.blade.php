<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Antrian Janji Temu Hari Ini</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Antrian Janji Temu - {{ \Carbon\Carbon::parse($today)->format('d M Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Spesialis</th>
                <th>Jadwal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->doctor->specialization }}</td>
                    <td>{{ $appointment->schedule->day }} ({{ $appointment->schedule->start_time }} -
                        {{ $appointment->schedule->end_time }})</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada janji temu hari ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
