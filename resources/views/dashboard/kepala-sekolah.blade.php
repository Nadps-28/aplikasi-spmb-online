@extends('layouts.kepala-sekolah')

@section('title', 'Dashboard Kepala Sekolah')
@section('page-title', 'Dashboard Kepala Sekolah')
@section('page-subtitle', 'Monitoring Keseluruhan SPMB')

@section('content')
<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-2 col-md-4">
        <div class="stats-card text-center">
            <div class="mb-3">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex">
                    <i class="fas fa-users text-primary fs-3"></i>
                </div>
            </div>
            <h3 class="mb-1">{{ number_format($kpi['total_pendaftar']) }}</h3>
            <p class="text-muted mb-0 small">Total Pendaftar</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4">
        <div class="stats-card text-center">
            <div class="mb-3">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-flex">
                    <i class="fas fa-graduation-cap text-success fs-3"></i>
                </div>
            </div>
            <h3 class="mb-1">{{ $kpi['total_jurusan'] }}</h3>
            <p class="text-muted mb-0 small">Jurusan Aktif</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4">
        <div class="stats-card text-center">
            <div class="mb-3">
                <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-flex">
                    <i class="fas fa-wave-square text-info fs-3"></i>
                </div>
            </div>
            <h3 class="mb-1">{{ $kpi['gelombang_aktif'] }}</h3>
            <p class="text-muted mb-0 small">Gelombang Aktif</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4">
        <div class="stats-card text-center">
            <div class="mb-3">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-flex">
                    <i class="fas fa-money-bill-wave text-warning fs-3"></i>
                </div>
            </div>
            <h4 class="mb-1 small">Rp {{ number_format($kpi['total_pemasukan']) }}</h4>
            <p class="text-muted mb-0 small">Total Pemasukan</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4">
        <div class="stats-card text-center">
            <div class="mb-3">
                <div class="bg-secondary bg-opacity-10 rounded-circle p-3 d-inline-flex">
                    <i class="fas fa-chart-bar text-secondary fs-3"></i>
                </div>
            </div>
            <h3 class="mb-1">{{ $kpi['rata_pendaftar_per_jurusan'] }}</h3>
            <p class="text-muted mb-0 small">Rata-rata/Jurusan</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4">
        <div class="stats-card text-center">
            <div class="mb-3">
                <div class="bg-danger bg-opacity-10 rounded-circle p-3 d-inline-flex">
                    <i class="fas fa-percentage text-danger fs-3"></i>
                </div>
            </div>
            <h3 class="mb-1">{{ $kpi['rasio_terverifikasi'] }}%</h3>
            <p class="text-muted mb-0 small">Rasio Terverifikasi</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tren Pendaftaran 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="trenChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Verifikasi</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Analysis Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pendaftar per Jurusan</h5>
            </div>
            <div class="card-body">
                <canvas id="jurusanChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Top 5 Asal Sekolah</h5>
                <a href="{{ route('kepala-sekolah.kelulusan') }}" class="btn btn-sm btn-outline-primary">
                    Detail Kelulusan
                </a>
            </div>
            <div class="card-body">
                @if($asalSekolah->count() > 0)
                    @foreach($asalSekolah as $sekolah)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $sekolah->asal_sekolah }}</strong>
                            <br>
                            <small class="text-muted">{{ $sekolah->total }} pendaftar</small>
                        </div>
                        <div class="text-end">
                            <div class="progress" style="width: 100px; height: 8px;">
                                <div class="progress-bar bg-primary" style="width: {{ ($sekolah->total / $asalSekolah->first()->total) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-school text-muted fs-2 mb-2"></i>
                        <p class="text-muted">Belum ada data asal sekolah</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Regional Analysis -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top 5 Asal Wilayah</h5>
            </div>
            <div class="card-body">
                @if($asalWilayah->count() > 0)
                    @foreach($asalWilayah as $wilayah)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $wilayah->kecamatan }}</strong>
                            <br>
                            <small class="text-muted">{{ $wilayah->total }} pendaftar</small>
                        </div>
                        <div class="text-end">
                            <div class="progress" style="width: 100px; height: 8px;">
                                <div class="progress-bar bg-success" style="width: {{ ($wilayah->total / $asalWilayah->first()->total) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-map-marker-alt text-muted fs-2 mb-2"></i>
                        <p class="text-muted">Belum ada data asal wilayah</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                @if($aktivitas->count() > 0)
                    @foreach($aktivitas as $item)
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">
                                <strong>{{ $item->user->name ?? 'Unknown' }}</strong> 
                                mendaftar
                            </p>
                            <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-{{ $item->status == 'lulus' ? 'success' : ($item->status == 'valid' ? 'info' : 'secondary') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-inbox text-muted fs-2 mb-2"></i>
                        <p class="text-muted">Belum ada aktivitas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Tren Chart
const trenCtx = document.getElementById('trenChart').getContext('2d');
new Chart(trenCtx, {
    type: 'line',
    data: {
        labels: @json(collect($trenHarian)->pluck('label')),
        datasets: [{
            label: 'Pendaftar Harian',
            data: @json(collect($trenHarian)->pluck('total')),
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            borderColor: 'rgba(37, 99, 235, 1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(37, 99, 235, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: 'white',
                bodyColor: 'white',
                borderColor: 'rgba(255, 255, 255, 0.1)',
                borderWidth: 1,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        return 'Pendaftar: ' + context.parsed.y + ' orang';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' },
                ticks: {
                    stepSize: 1,
                    callback: function(value) {
                        return value + ' orang';
                    }
                }
            },
            x: { grid: { display: false } }
        }
    }
});

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Menunggu', 'Diproses', 'Lulus', 'Ditolak'],
        datasets: [{
            data: [
                {{ $statusData['menunggu'] }},
                {{ $statusData['diproses'] }},
                {{ $statusData['lulus'] }},
                {{ $statusData['ditolak'] + $statusData['ditolak_verifikator'] }}
            ],
            backgroundColor: [
                'rgba(245, 158, 11, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(239, 68, 68, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Jurusan Chart
const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
new Chart(jurusanCtx, {
    type: 'bar',
    data: {
        labels: @json($jurusanData->pluck('nama')),
        datasets: [{
            label: 'Jumlah Pendaftar',
            data: @json($jurusanData->pluck('pendaftarans_count')),
            backgroundColor: 'rgba(16, 185, 129, 0.8)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: 'white',
                bodyColor: 'white',
                borderColor: 'rgba(255, 255, 255, 0.1)',
                borderWidth: 1,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        return 'Pendaftar: ' + context.parsed.y + ' orang';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' },
                ticks: {
                    stepSize: 1,
                    callback: function(value) {
                        return value + ' orang';
                    }
                }
            },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endsection