@extends('layouts.kepala-sekolah')

@section('title', 'Analytics Dashboard - SPMB SMK Bakti Nusantara 666')
@section('page-title', 'Analytics Dashboard')
@section('page-subtitle', 'Monitoring dan analisis data SPMB secara real-time')

@section('content')
<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
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
    <div class="col-lg-3 col-md-6">
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

<!-- Charts Section -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Tren Pendaftaran Harian (30 Hari)</h6>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary active" onclick="updateTrenChart('30')">30 Hari</button>
                    <button class="btn btn-outline-primary" onclick="updateTrenChart('7')">7 Hari</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="trenChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Distribusi per Jurusan</h6>
            </div>
            <div class="card-body">
                <canvas id="jurusanChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Details -->
<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Top 10 Asal Sekolah</h6>
            </div>
            <div class="card-body">
                @forelse($asalSekolah as $index => $sekolah)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="badge bg-primary rounded-circle me-3" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="fw-semibold" title="{{ $sekolah->asal_sekolah }}">
                                {{ Str::limit($sekolah->asal_sekolah, 25) }}
                            </div>
                            <small class="text-muted">{{ round(($sekolah->total / $kpi['total_pendaftar']) * 100, 1) }}% dari total</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-primary">{{ $sekolah->total }}</div>
                        <div class="progress mt-1" style="width: 60px; height: 4px;">
                            <div class="progress-bar bg-primary" style="width: {{ ($sekolah->total / $kpi['total_pendaftar']) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-school fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada data asal sekolah</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Top 10 Asal Wilayah</h6>
            </div>
            <div class="card-body">
                @forelse($asalWilayah as $index => $wilayah)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="badge bg-success rounded-circle me-3" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $wilayah->kecamatan }}</div>
                            <small class="text-muted">{{ round(($wilayah->total / $kpi['total_pendaftar']) * 100, 1) }}% dari total</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success">{{ $wilayah->total }}</div>
                        <div class="progress mt-1" style="width: 60px; height: 4px;">
                            <div class="progress-bar bg-success" style="width: {{ ($wilayah->total / $kpi['total_pendaftar']) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada data asal wilayah</p>
                </div>
                @endforelse
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
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data untuk charts
const jurusanData = @json($jurusans);
const trenData = @json($trenHarian);

// Chart Distribusi Jurusan
const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
const jurusanChart = new Chart(jurusanCtx, {
    type: 'doughnut',
    data: {
        labels: jurusanData.map(j => j.nama),
        datasets: [{
            label: 'Pendaftar',
            data: jurusanData.map(j => j.pendaftar),
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        }
    }
});

// Chart Tren Harian
const trenCtx = document.getElementById('trenChart').getContext('2d');
const trenChart = new Chart(trenCtx, {
    type: 'line',
    data: {
        labels: trenData.map(t => new Date(t.tanggal).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'})),
        datasets: [{
            label: 'Pendaftar',
            data: trenData.map(t => t.total),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { 
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

function updateTrenChart(days) {
    // Update active button
    document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Fetch new data based on days parameter
    fetch(`/kepala-sekolah/analytics/tren/${days}`)
        .then(response => response.json())
        .then(data => {
            trenChart.data.labels = data.map(t => new Date(t.tanggal).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'}));
            trenChart.data.datasets[0].data = data.map(t => t.total);
            trenChart.update();
        })
        .catch(error => console.log('Error updating chart:', error));
}

// Auto refresh KPI setiap 60 detik
setInterval(function() {
    if (document.visibilityState === 'visible') {
        fetch('/kepala-sekolah/analytics/kpi')
            .then(response => response.json())
            .then(data => {
                // Update KPI numbers
                const kpiNumbers = document.querySelectorAll('.kpi-number');
                if (kpiNumbers[0]) kpiNumbers[0].textContent = data.total_pendaftar;
                if (kpiNumbers[1]) kpiNumbers[1].textContent = data.lulus;
                if (kpiNumbers[2]) kpiNumbers[2].textContent = (data.pemasukan / 1000000).toFixed(1) + 'M';
                if (kpiNumbers[3]) kpiNumbers[3].textContent = data.rasio_terverifikasi + '%';
            })
            .catch(error => console.log('Auto refresh error:', error));
    }
}, 60000);
</script>
@endsection