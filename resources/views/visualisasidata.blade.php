<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visualisasi Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js & Datalabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .chart-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 30px;
        }
        .chart-container {
            position: relative;
            height: 300px;
            max-width: 100%;
        }
        h5.card-title {
            font-weight: 600;
            margin-bottom: 20px;
            color: #343a40;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <x-navbar></x-navbar>

    <div class="content" style="margin-left: 180px; padding: 40px;">
        <div class="container">
            <h4 class="mb-4">📈 Visualisasi Data</h4>

            {{-- Pie Chart --}}
            <div class="chart-card">
                <h5 class="card-title">🧩 Proporsi Data per Klaster</h5>
                <div class="chart-container" style="height: 400px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
            
            {{-- Bar Chart --}}
            <div class="chart-card">
                <h5 class="card-title">📊 Skor Prioritas Klaster</h5>
                <div class="chart-container" style="height: 400px;">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            {{-- Radar Chart --}}
            <div class="chart-card">
                <h5 class="card-title">🕸️ Profil Rata-Rata Setiap Klaster</h5>
                <div class="chart-container" style="height: 500px;">
                    <canvas id="radarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const pieLabels = {!! json_encode($hasil->groupBy('cluster_id')->keys()) !!}.map(id => id);
    const pieData = {!! json_encode($hasil->groupBy('cluster_id')->map->count()->values()) !!};

    const barLabels = {!! json_encode(array_keys($cluster_priorities)) !!};
    const barData = {!! json_encode(array_values($cluster_priorities)) !!};

    const radarLabels = {!! json_encode(array_keys($cluster_averages[array_key_first($cluster_averages)])) !!};

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    color: '#fff',
                    formatter: (value, ctx) => value,
                    font: {
                        weight: 'bold',
                        size: 14
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: barLabels.map(id => id),
            datasets: [{
                label: 'Skor Rata-rata',
                data: barData,
                backgroundColor: '#36A2EB',
                borderColor: '#007bff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            },
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold'
                    },
                    formatter: (value) => value.toFixed(2)
                },
                legend: {
                    display: false
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Radar Chart
    new Chart(document.getElementById('radarChart'), {
        type: 'radar',
        data: {
            labels: radarLabels,
            datasets: [
                @foreach ($cluster_averages as $cluster_id => $averages)
                {
                    label: '{{ $cluster_id }}',
                    data: {!! json_encode(array_values($averages)) !!},
                    fill: true,
                    tension: 0.1,
                    borderColor: '{{ ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'][$loop->index % 6] }}',
                    backgroundColor: '{{ ['rgba(255,99,132,0.2)', 'rgba(54,162,235,0.2)', 'rgba(255,206,86,0.2)', 'rgba(75,192,192,0.2)', 'rgba(153,102,255,0.2)', 'rgba(255,159,64,0.2)'][$loop->index % 6] }}',
                    pointBackgroundColor: '{{ ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'][$loop->index % 6] }}'
                },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 5,
                    pointLabels: {
                        font: {
                            size: 14 // Adjust point label font size here
                        }
                    },
                    ticks: {
                        font: {
                            size: 12 // Adjust the font size of the radial scale ticks
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14 // Adjust legend font size here
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>
