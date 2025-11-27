@extends('layouts.kepala-sekolah')

@section('title', 'Laporan Kepala Sekolah - SPMB SMK Bakti Nusantara 666')
@section('page-title', 'Laporan Kepala Sekolah')
@section('page-subtitle', 'Laporan komprehensif sistem penerimaan siswa baru')

@section('content')
<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-1">Laporan Komprehensif</h5>
                <p class="text-muted mb-0">Generate dan export laporan dalam berbagai format</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success" onclick="exportLaporan('excel')">
                    <i class="fas fa-file-excel me-1"></i>Export Excel
                </button>
                <button class="btn btn-danger" onclick="exportLaporan('pdf')">
                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                </button>
                <button class="btn btn-primary" onclick="printLaporan()">
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="summary-card">
            <div class="summary-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="summary-content">
                <h3>{{ $kpi['total_pendaftar'] }}</h3>
                <p>Total Pendaftar</p>
                <small class="text-success">+12% dari periode sebelumnya</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="summary-card">
            <div class="summary-icon bg-success">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="summary-content">
                <h3>{{ $kpi['lulus'] }}</h3>
                <p>Siswa Diterima</p>
                <small class="text-info">{{ $kpi['total_pendaftar'] > 0 ? round(($kpi['lulus'] / $kpi['total_pendaftar']) * 100, 1) : 0 }}% dari total pendaftar</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="summary-card">
            <div class="summary-icon bg-warning">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="summary-content">
                <h3>Rp {{ number_format($kpi['pemasukan'] / 1000000, 1) }}M</h3>
                <p>Total Pemasukan</p>
                <small class="text-muted">Rp {{ number_format($kpi['pemasukan'], 0, ',', '.') }}</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="summary-card">
            <div class="summary-icon bg-info">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="summary-content">
                <h3>{{ $kpi['rasio_terverifikasi'] }}%</h3>
                <p>Rasio Verifikasi</p>
                <small class="text-success">Tingkat verifikasi tinggi</small>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Laporan Detail per Jurusan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Jurusan</th>
                                <th class="text-center">Pendaftar</th>
                                <th class="text-center">Diterima</th>
                                <th class="text-center">Rasio</th>
                                <th class="text-center">Pemasukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jurusans as $jurusan)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 12px;">
                                            {{ strtoupper(substr($jurusan['nama'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $jurusan['nama'] }}</div>
                                            <small class="text-muted">Jurusan Aktif</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">{{ $jurusan['pendaftar'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $jurusan['lulus'] ?? 0 }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">
                                        {{ $jurusan['pendaftar'] > 0 ? round((($jurusan['lulus'] ?? 0) / $jurusan['pendaftar']) * 100, 1) : 0 }}%
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-success fw-semibold">
                                        Rp {{ number_format(($jurusan['pemasukan'] ?? 0), 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Ringkasan Periode</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Periode Laporan</span>
                        <span class="fw-semibold">{{ now()->format('F Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Tanggal Generate</span>
                        <span class="fw-semibold">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Status Sistem</span>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <h6 class="fw-bold mb-2">Statistik Cepat</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Rata-rata per hari</span>
                        <span class="fw-semibold">{{ round($kpi['total_pendaftar'] / 30, 1) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Jurusan terpopuler</span>
                        <span class="fw-semibold">{{ $jurusans->sortByDesc('pendaftar')->first()['nama'] ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tingkat penerimaan</span>
                        <span class="fw-semibold text-success">{{ $kpi['total_pendaftar'] > 0 ? round(($kpi['lulus'] / $kpi['total_pendaftar']) * 100, 1) : 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" onclick="window.location.href='{{ route('kepala-sekolah.analytics') }}'">
                        <i class="fas fa-chart-line me-2"></i>Lihat Analytics
                    </button>
                    <button class="btn btn-outline-success" onclick="exportLaporan('excel')">
                        <i class="fas fa-download me-2"></i>Download Excel
                    </button>
                    <button class="btn btn-outline-info" onclick="window.location.href='{{ route('export.pendaftar') }}'">
                        <i class="fas fa-users me-2"></i>Export Pendaftar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Analysis -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Analisis Mendalam</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h6 class="fw-semibold mb-3">Top 5 Asal Sekolah</h6>
                        @foreach($asalSekolah->take(5) as $index => $sekolah)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                <span title="{{ $sekolah->asal_sekolah }}">{{ Str::limit($sekolah->asal_sekolah, 30) }}</span>
                            </div>
                            <span class="fw-bold">{{ $sekolah->total }} siswa</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="col-lg-6">
                        <h6 class="fw-semibold mb-3">Top 5 Asal Wilayah</h6>
                        @foreach($asalWilayah->take(5) as $index => $wilayah)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $index + 1 }}</span>
                                <span>{{ $wilayah->kecamatan }}</span>
                            </div>
                            <span class="fw-bold">{{ $wilayah->total }} siswa</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.summary-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
}

.summary-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.summary-content h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #1a202c;
}

.summary-content p {
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.summary-content small {
    font-size: 0.8rem;
}

@media (max-width: 768px) {
    .summary-card {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }
    
    .summary-content h3 {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
function exportLaporan(format) {
    const url = format === 'excel' ? '{{ route("kepala-sekolah.laporan.excel") }}' : '{{ route("kepala-sekolah.laporan.pdf") }}';
    window.open(url, '_blank');
}

function printLaporan() {
    window.print();
}

// Print styles
const printStyles = `
    @media print {
        .btn, .card-header, .summary-icon { display: none !important; }
        .card { border: 1px solid #ddd !important; box-shadow: none !important; }
        .summary-card { border: 1px solid #ddd !important; }
        body { font-size: 12px; }
        .table { font-size: 11px; }
    }
`;

const styleSheet = document.createElement("style");
styleSheet.type = "text/css";
styleSheet.innerText = printStyles;
document.head.appendChild(styleSheet);
</script>
@endsection