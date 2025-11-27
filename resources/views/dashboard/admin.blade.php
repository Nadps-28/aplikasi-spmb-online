@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Monitoring dan Manajemen SPMB')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-primary rounded-3 p-3 text-white">
                            <i class="fas fa-users fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="fw-bold mb-0 text-gray-900">{{ number_format($stats['total_pendaftar']) }}</h2>
                        <p class="text-sm text-gray-600 mb-0">Total Pendaftar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-success rounded-3 p-3 text-white">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="fw-bold mb-0 text-gray-900">{{ number_format($stats['terverifikasi']) }}</h2>
                        <p class="text-sm text-gray-600 mb-0">Terverifikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-info rounded-3 p-3 text-white">
                            <i class="fas fa-money-bill-wave fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="fw-bold mb-0 text-gray-900">{{ number_format($stats['terbayar']) }}</h2>
                        <p class="text-sm text-gray-600 mb-0">Sudah Bayar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-warning rounded-3 p-3 text-white">
                            <i class="fas fa-graduation-cap fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="fw-bold mb-0 text-gray-900">{{ number_format($stats['lulus']) }}</h2>
                        <p class="text-sm text-gray-600 mb-0">Lulus</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.text-gray-900 { color: #111827; }
.text-gray-600 { color: #4b5563; }
.text-xs { font-size: 0.75rem; }
</style>

<!-- Charts Row -->
<div class="row g-4 mb-5">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Pendaftar per Jurusan</h5>
                        <p class="text-sm text-gray-600 mb-0">Distribusi pendaftar berdasarkan program studi</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" id="filterButton">
                            <i class="fas fa-calendar me-1"></i> <span id="filterText">Semua Waktu</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-option" href="#" data-days="7">7 Hari Terakhir</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-days="30">30 Hari Terakhir</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-days="90">90 Hari Terakhir</a></li>
                            <li><a class="dropdown-item filter-option active" href="#" data-days="all">Semua Waktu</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="chartLoading" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat data...</p>
                </div>
                <div style="height: 280px;">
                    <canvas id="jurusanChart"></canvas>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="border-end border-light">
                                <div class="p-2">
                                    <h5 class="fw-bold text-primary mb-1" id="totalPendaftarChart">{{ array_sum($chartData['jurusan_data']) }}</h5>
                                    <small class="text-muted fw-medium">Total Pendaftar</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border-end border-light">
                                <div class="p-2">
                                    <h6 class="fw-bold text-success mb-1" id="jurusanTerpopuler" style="font-size: 0.9rem;">{{ count($chartData['jurusan_labels']) > 0 && count($chartData['jurusan_data']) > 0 && max($chartData['jurusan_data']) > 0 ? $chartData['jurusan_labels'][array_search(max($chartData['jurusan_data']), $chartData['jurusan_data'])] : '-' }}</h6>
                                    <small class="text-muted fw-medium">Jurusan Terpopuler</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2">
                                <h5 class="fw-bold text-info mb-1" id="rataRataPendaftar">{{ count($chartData['jurusan_labels']) > 0 ? round(array_sum($chartData['jurusan_data']) / count($chartData['jurusan_labels']), 1) : 0 }}</h5>
                                <small class="text-muted fw-medium">Rata-rata per Jurusan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-bold mb-1">Pemasukan 7 Hari</h5>
                <p class="text-sm text-gray-600 mb-0">Tren pemasukan harian</p>
            </div>
            <div class="card-body">
                <div style="height: 280px;">
                    <canvas id="pemasukanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity & Quick Actions -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">Aktivitas Terbaru</h5>
                    <p class="text-sm text-gray-600 mb-0">Pantau aktivitas sistem secara real-time</p>
                </div>
                <a href="{{ route('admin.monitoring') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if(count($aktivitas) > 0)
                    <div class="activity-timeline">
                        @foreach($aktivitas as $item)
                        <div class="d-flex align-items-start mb-4 pb-3 border-bottom border-light">
                            <div class="flex-shrink-0">
                                <div class="bg-{{ $item['color'] }} bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-{{ $item['icon'] }} text-{{ $item['color'] }} fs-5"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="fw-semibold mb-1 text-gray-900">{{ $item['text'] }}</p>
                                <small class="text-gray-500"><i class="fas fa-clock me-1"></i>{{ $item['time'] }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="bg-gray-100 rounded-circle p-4 d-inline-flex mb-3">
                            <i class="fas fa-inbox text-gray-400 fs-1"></i>
                        </div>
                        <h6 class="fw-semibold text-gray-700">Belum ada aktivitas</h6>
                        <p class="text-gray-500 mb-0">Aktivitas terbaru akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="fw-bold mb-1">Quick Actions</h5>
                <p class="text-sm text-gray-600 mb-0">Akses cepat ke fitur utama</p>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.master-data') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-start">
                        <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                            <i class="fas fa-database text-primary"></i>
                        </div>
                        <div class="text-start">
                            <div class="fw-semibold">Master Data</div>
                            <small class="text-muted">Kelola jurusan & gelombang</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.monitoring') }}" class="btn btn-outline-success d-flex align-items-center justify-content-start">
                        <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                            <i class="fas fa-chart-line text-success"></i>
                        </div>
                        <div class="text-start">
                            <div class="fw-semibold">Monitoring</div>
                            <small class="text-muted">Pantau berkas pendaftar</small>
                        </div>
                    </a>
                    <a href="{{ route('export.pendaftar') }}" class="btn btn-outline-info d-flex align-items-center justify-content-start">
                        <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                            <i class="fas fa-download text-info"></i>
                        </div>
                        <div class="text-start">
                            <div class="fw-semibold">Export Data</div>
                            <small class="text-muted">Download laporan</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.peta-sebaran') }}" class="btn btn-outline-warning d-flex align-items-center justify-content-start">
                        <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                            <i class="fas fa-map text-warning"></i>
                        </div>
                        <div class="text-start">
                            <div class="fw-semibold">Peta Sebaran</div>
                            <small class="text-muted">Visualisasi geografis</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Global chart variable
let jurusanChart;

// Initialize chart
function initJurusanChart(labels, data) {
    const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
    
    // Destroy existing chart if exists
    if (jurusanChart) {
        jurusanChart.destroy();
    }
    
    // Create gradient colors for better visualization
    const colors = [
        'rgba(37, 99, 235, 0.8)',   // Blue
        'rgba(16, 185, 129, 0.8)',  // Green
        'rgba(245, 158, 11, 0.8)',  // Yellow
        'rgba(239, 68, 68, 0.8)',   // Red
        'rgba(139, 92, 246, 0.8)',  // Purple
        'rgba(236, 72, 153, 0.8)',  // Pink
        'rgba(6, 182, 212, 0.8)',   // Cyan
        'rgba(34, 197, 94, 0.8)'    // Emerald
    ];
    
    const backgroundColors = data.map((_, index) => colors[index % colors.length]);
    const borderColors = backgroundColors.map(color => color.replace('0.8', '1'));
    
    jurusanChart = new Chart(jurusanCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: data,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2.5,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            return 'Pendaftar: ' + context.parsed.y + ' orang';
                        },
                        afterLabel: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                            return 'Persentase: ' + percentage + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return value + ' orang';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}



// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize chart with default data
    initJurusanChart(@json($chartData['jurusan_labels']), @json($chartData['jurusan_data']));
    
    // Filter event listeners
    document.querySelectorAll('.filter-option').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const days = this.getAttribute('data-days');
            const filterText = this.textContent;
            
            // Update active state
            document.querySelectorAll('.filter-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Update button text
            document.getElementById('filterText').textContent = filterText;
            
            // Show loading
            document.getElementById('chartLoading').style.display = 'block';
            document.getElementById('jurusanChart').style.opacity = '0.3';
            
            // Fetch filtered data
            fetch(`/dashboard/chart-data?days=${days}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading
                document.getElementById('chartLoading').style.display = 'none';
                document.getElementById('jurusanChart').style.opacity = '1';
                
                // Update chart
                initJurusanChart(data.labels, data.data);
                
                // Update statistics
                const total = data.data.reduce((a, b) => a + b, 0);
                const maxValue = Math.max(...data.data);
                const maxIndex = data.data.indexOf(maxValue);
                const average = data.data.length > 0 ? (total / data.data.length).toFixed(1) : 0;
                
                document.getElementById('totalPendaftarChart').textContent = total;
                document.getElementById('rataRataPendaftar').textContent = average;
                
                // Update most popular major
                if (data.labels.length > 0 && maxIndex >= 0 && maxValue > 0) {
                    document.getElementById('jurusanTerpopuler').textContent = data.labels[maxIndex];
                } else {
                    document.getElementById('jurusanTerpopuler').textContent = '-';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('chartLoading').style.display = 'none';
                document.getElementById('jurusanChart').style.opacity = '1';
                alert('Terjadi kesalahan saat memuat data');
            });
        });
    });
});

// Pemasukan Chart
const pemasukanCtx = document.getElementById('pemasukanChart').getContext('2d');
new Chart(pemasukanCtx, {
    type: 'line',
    data: {
        labels: @json($chartData['pemasukan_labels']),
        datasets: [{
            label: 'Pemasukan Harian',
            data: @json($chartData['pemasukan_data']),
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(16, 185, 129, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2.5,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: 'white',
                bodyColor: 'white',
                borderColor: 'rgba(255, 255, 255, 0.1)',
                borderWidth: 1,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        return 'Pemasukan: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)',
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID', { 
                            notation: 'compact', 
                            compactDisplay: 'short' 
                        }).format(value);
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeInOutQuart'
        }
    }
});
</script>
@endsection