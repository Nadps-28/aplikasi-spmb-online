@extends('layouts.kepala-sekolah')

@section('title', 'Analytics & Laporan - SPMB SMK Bakti Nusantara 666')
@section('page-title', 'Analytics & Laporan')
@section('page-subtitle', 'Analisis mendalam sistem penerimaan siswa baru')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Dashboard Analitik Kepala Sekolah</h3>
                <p class="text-muted mb-0">Analisis mendalam sistem penerimaan siswa baru</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="exportKelulusan()">
                    <i class="fas fa-download me-1"></i>Export Laporan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-4 col-md-6">
        <div class="kpi-card bg-gradient-primary">
            <div class="kpi-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-number">{{ $kpi['total_pendaftar'] }}</div>
                <div class="kpi-label">Total Pendaftar</div>
                <div class="kpi-trend">+12% dari bulan lalu</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="kpi-card bg-gradient-success">
            <div class="kpi-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-number">{{ $kpi['lulus'] }}</div>
                <div class="kpi-label">Siswa Lulus</div>
                <div class="kpi-trend">{{ $kpi['total_pendaftar'] > 0 ? round(($kpi['lulus'] / $kpi['total_pendaftar']) * 100, 1) : 0 }}% dari total</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="kpi-card bg-gradient-warning">
            <div class="kpi-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-number">{{ number_format($kpi['pemasukan'] / 1000000, 1) }}M</div>
                <div class="kpi-label">Total Pemasukan</div>
                <div class="kpi-trend">Rp {{ number_format($kpi['pemasukan'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="kpi-card bg-gradient-info">
            <div class="kpi-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-number">{{ $kpi['rasio_terverifikasi'] }}%</div>
                <div class="kpi-label">Rasio Terverifikasi</div>
                <div class="kpi-trend">{{ $kpi['total_pendaftar'] > 0 ? round(($kpi['lulus'] / $kpi['total_pendaftar']) * 100, 1) : 0 }}% lulus</div>
            </div>
        </div>
    </div>
</div>

<style>
.kpi-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: none;
}

.kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.bg-gradient-primary::before { background: linear-gradient(90deg, #667eea, #764ba2); }
.bg-gradient-success::before { background: linear-gradient(90deg, #11998e, #38ef7d); }
.bg-gradient-info::before { background: linear-gradient(90deg, #4facfe, #00f2fe); }
.bg-gradient-warning::before { background: linear-gradient(90deg, #f093fb, #f5576c); }

/* Responsive adjustments */
@media (max-width: 768px) {
    .kpi-card {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .kpi-number {
        font-size: 2rem;
    }
    
    .kpi-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

/* Hover effects */
.kpi-card:hover .kpi-icon {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.6s ease;
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.kpi-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    color: white;
}

.bg-gradient-primary .kpi-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.bg-gradient-success .kpi-icon { background: linear-gradient(135deg, #11998e, #38ef7d); }
.bg-gradient-info .kpi-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.bg-gradient-warning .kpi-icon { background: linear-gradient(135deg, #f093fb, #f5576c); }

.kpi-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a202c;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.kpi-label {
    color: #4a5568;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.kpi-trend {
    color: #718096;
    font-size: 0.875rem;
    font-weight: 500;
}
</style>

<!-- Grafik Analitik -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Distribusi Pendaftar per Jurusan</h6>
            </div>
            <div class="card-body">
                <canvas id="kuotaChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Tren Pendaftaran Harian (30 Hari)</h6>
            </div>
            <div class="card-body">
                <canvas id="trenChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Komposisi Asal Sekolah</h6>
            </div>
            <div class="card-body">
                @forelse($asalSekolah as $sekolah)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span title="{{ $sekolah->asal_sekolah }}">{{ Str::limit($sekolah->asal_sekolah, 30) }}</span>
                    <div class="d-flex align-items-center">
                        <div class="progress me-2" style="width: 80px; height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ ($sekolah->total / $kpi['total_pendaftar']) * 100 }}%"></div>
                        </div>
                        <span class="fw-bold">{{ $sekolah->total }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-3">
                    <i class="fas fa-school fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">Belum ada data asal sekolah</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Komposisi Asal Wilayah</h6>
            </div>
            <div class="card-body">
                @forelse($asalWilayah as $wilayah)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ $wilayah->kecamatan }}</span>
                    <div class="d-flex align-items-center">
                        <div class="progress me-2" style="width: 80px; height: 8px;">
                            <div class="progress-bar bg-primary" style="width: {{ ($wilayah->total / $kpi['total_pendaftar']) * 100 }}%"></div>
                        </div>
                        <span class="fw-bold">{{ $wilayah->total }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-3">
                    <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">Belum ada data asal wilayah</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Distribusi Pendaftar per Jurusan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($jurusans as $index => $jurusan)
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="text-center p-3 border rounded">
                            <div class="mb-2">
                                <i class="fas fa-graduation-cap fa-2x text-{{ ['primary', 'success', 'warning', 'info', 'danger'][$index % 5] }}"></i>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $jurusan['pendaftar'] }}</h5>
                            <small class="text-muted">{{ $jurusan['nama'] }}</small>
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar bg-{{ ['primary', 'success', 'warning', 'info', 'danger'][$index % 5] }}" 
                                     style="width: {{ $kpi['total_pendaftar'] > 0 ? ($jurusan['pendaftar'] / $kpi['total_pendaftar']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Distribusi Pendaftar
const kuotaCtx = document.getElementById('kuotaChart').getContext('2d');
const kuotaData = @json($jurusans);
new Chart(kuotaCtx, {
    type: 'doughnut',
    data: {
        labels: kuotaData.map(j => j.nama),
        datasets: [{
            label: 'Pendaftar',
            data: kuotaData.map(j => j.pendaftar),
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Grafik Tren Harian
const trenCtx = document.getElementById('trenChart').getContext('2d');
const trenData = @json($trenHarian);
new Chart(trenCtx, {
    type: 'line',
    data: {
        labels: trenData.map(t => new Date(t.tanggal).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'})),
        datasets: [{
            label: 'Pendaftar',
            data: trenData.map(t => t.total),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

function exportKelulusan() {
    // Generate laporan dalam format yang dapat dicetak
    window.open('/kepala-sekolah/kelulusan/export', '_blank');
}

// Auto refresh data setiap 60 detik
setInterval(function() {
    // Refresh halaman untuk update data terbaru
    if (document.visibilityState === 'visible') {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                // Update hanya bagian KPI tanpa refresh seluruh halaman
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newKpiCards = doc.querySelectorAll('.kpi-number');
                const currentKpiCards = document.querySelectorAll('.kpi-number');
                
                newKpiCards.forEach((newCard, index) => {
                    if (currentKpiCards[index]) {
                        currentKpiCards[index].textContent = newCard.textContent;
                    }
                });
            })
            .catch(error => console.log('Auto refresh error:', error));
    }
}, 60000); // 60 detik
</script>
@endsection