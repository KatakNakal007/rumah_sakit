@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="chart-wrapper">
            <canvas id="grafikDokter" width="300" height="200"></canvas>
            <canvas id="grafikStatus" width="300" height="200" class="mt-4"></canvas>
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
    </div>
@section('content')
