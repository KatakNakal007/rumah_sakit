<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Janji Temu</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .section {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>Detail Janji Temu</h2>

    <div class="section"><strong>Pasien:</strong> {{ $appointment->patient->name }}</div>
    <div class="section"><strong>Dokter:</strong> {{ $appointment->doctor->name }}
        ({{ $appointment->doctor->specialization }})</div>
    <div class="section"><strong>Jadwal:</strong> {{ $appointment->schedule->day }}
        ({{ $appointment->schedule->start_time }} - {{ $appointment->schedule->end_time }})</div>
    <div class="section"><strong>Tanggal:</strong> {{ $appointment->appointment_date }}</div>
    <div class="section"><strong>Status:</strong> {{ ucfirst($appointment->status) }}</div>
</body>

</html>
