@extends('layouts.keuangan')

@section('title', 'Dashboard Keuangan - SPMB SMK Bakti Nusantara 666')
@section('page-title', 'Dashboard Keuangan')
@section('page-subtitle', 'Verifikasi Pembayaran dan Laporan Keuangan')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ number_format($stats['menunggu_verifikasi']) }}</h3>
                    <p class="text-muted mb-0">Menunggu Verifikasi</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3">
                        <i class="fas fa-money-bill-wave text-success fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">Rp {{ number_format($stats['pemasukan_hari_ini']) }}</h3>
                    <p class="text-muted mb-0">Pemasukan Hari Ini</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                        <i class="fas fa-chart-line text-primary fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">Rp {{ number_format($stats['total_pemasukan']) }}</h3>
                    <p class="text-muted mb-0">Total Pemasukan</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-info bg-opacity-10 rounded-3 p-3">
                        <i class="fas fa-percentage text-info fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ $stats['tingkat_verifikasi'] }}%</h3>
                    <p class="text-muted mb-0">Tingkat Verifikasi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart & Pending Payments -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tren Pemasukan 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="pemasukanChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ringkasan Mingguan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pemasukan Minggu Ini</span>
                        <strong>Rp {{ number_format($stats['pemasukan_minggu']) }}</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pemasukan Bulan Ini</span>
                        <strong>Rp {{ number_format($stats['pemasukan_bulan_ini']) }}</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 60%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pembayaran Valid</span>
                        <strong>{{ number_format($stats['pembayaran_valid']) }}</strong>
                    </div>
                </div>
                
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pembayaran Ditolak</span>
                        <strong class="text-danger">{{ number_format($stats['pembayaran_ditolak']) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Payments Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Pembayaran Menunggu Verifikasi</h5>
        <a href="{{ route('export.keuangan') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-download me-1"></i>Export Laporan
        </a>
    </div>
    <div class="card-body">
        @if($pembayaran_pending->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Nominal</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaran_pending as $pembayaran)
                    <tr>
                        <td>
                            <span class="badge bg-primary">{{ $pembayaran->pendaftaran->nomor_pendaftaran }}</span>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $pembayaran->pendaftaran->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $pembayaran->pendaftaran->nama_lengkap }}</small>
                            </div>
                        </td>
                        <td>{{ $pembayaran->pendaftaran->jurusan->nama ?? '-' }}</td>
                        <td>
                            <strong class="text-success">Rp {{ number_format($pembayaran->nominal) }}</strong>
                        </td>
                        <td>
                            <small>{{ $pembayaran->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('keuangan.show', $pembayaran) }}" class="btn btn-warning text-white" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($pembayaran->bukti_bayar)
                                <a href="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" target="_blank" class="btn btn-info text-white" title="Lihat Bukti">
                                    <i class="fas fa-image"></i>
                                </a>
                                @endif
                                <button type="button" class="btn btn-success" title="Terima" onclick="verifikasiPembayaran({{ $pembayaran->id }}, 'verified')">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-danger" title="Tolak" onclick="verifikasiPembayaran({{ $pembayaran->id }}, 'rejected')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-check-circle text-success fs-1 mb-3"></i>
            <h5>Semua Pembayaran Sudah Diverifikasi</h5>
            <p class="text-muted">Tidak ada pembayaran yang menunggu verifikasi saat ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Pemasukan Chart
const ctx = document.getElementById('pemasukanChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartData['labels']),
        datasets: [{
            label: 'Pemasukan Harian',
            data: @json($chartData['data']),
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(16, 185, 129, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});

// Verifikasi Pembayaran Function
function verifikasiPembayaran(pembayaranId, status) {
    const statusText = status === 'verified' ? 'menerima' : 'menolak';
    
    if (confirm(`Yakin ingin ${statusText} pembayaran ini?`)) {
        // Use form submission instead of AJAX for better error handling
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/keuangan/${pembayaranId}/verifikasi`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        
        form.appendChild(csrfToken);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection