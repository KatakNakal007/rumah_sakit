<div class="row">
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Total Janji Temu Hari Ini</h5>
                <h2>{{ $totalAppointments }}</h2>
            </div>
        </div>
    </div>
    <!-- Tambahkan card lain untuk status -->
</div>

<canvas id="grafikDokter"></canvas>
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
        type: 'pie',
        data: {
            labels: {!! json_encode($statusCounts->keys()) !!},
            datasets: [{
                data: {!! json_encode($statusCounts->values()) !!},
                backgroundColor: ['#f4af40', '#4faaf0', '#40f46a', '#f44040']
            }]
        }
    });
</script>
