<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Rumah Sakit</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('doctors.index') }}">Dokter</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('patients.index') }}">Pasien</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('schedules.index') }}">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('appointments.index') }}">Janji Temu</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('queues.index') }}">Antrian</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    {{-- @if (session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
