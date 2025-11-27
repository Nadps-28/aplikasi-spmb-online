@extends('layouts.app')

@section('title', 'Dashboard Verifikator')

@section('content')
<div class="verifikator-dashboard-header mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-section">
                    <div class="verifikator-badge mb-3">
                        <i class="fas fa-check-double me-2"></i>
                        Verifikator Panel
                    </div>
                    <h1 class="display-5 fw-bold text-white mb-3">Dashboard Verifikator</h1>
                    <p class="lead text-white-50 mb-0">Kelola verifikasi data dan berkas pendaftar dengan efisien</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="verifikator-stats-mini">
                    <div class="stat-mini">
                        <div class="stat-number">{{ $pendaftarans->count() }}</div>
                        <div class="stat-label">Menunggu Verifikasi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.verifikator-dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 3rem 0;
    margin: -2rem 0 0 0;
    position: relative;
    overflow: hidden;
    border-radius: 15px;
}

.verifikator-dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.verifikator-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.stat-mini {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.5rem;
}
</style>

<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon bg-gradient-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="metric-content">
                <div class="metric-number">{{ $pendaftarans->count() }}</div>
                <div class="metric-label">Menunggu Verifikasi</div>
                <div class="metric-change positive">
                    <i class="fas fa-arrow-up"></i> Perlu Review
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon bg-gradient-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="metric-content">
                <div class="metric-number">0</div>
                <div class="metric-label">Terverifikasi Hari Ini</div>
                <div class="metric-change positive">
                    <i class="fas fa-arrow-up"></i> Meningkat
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon bg-gradient-info">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="metric-content">
                <div class="metric-number">0</div>
                <div class="metric-label">Perlu Perbaikan</div>
                <div class="metric-change positive">
                    <i class="fas fa-arrow-up"></i> Meningkat
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon bg-gradient-primary">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="metric-content">
                <div class="metric-number">0</div>
                <div class="metric-label">Ditolak</div>
                <div class="metric-change positive">
                    <i class="fas fa-arrow-up"></i> Meningkat
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.metric-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.metric-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.metric-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
    color: white;
}

.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

.metric-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a202c;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.metric-label {
    color: #64748b;
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.metric-change {
    font-size: 0.875rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.metric-change.positive {
    color: #10b981;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0" style="color: #1e293b;">Daftar Pendaftar Menunggu Verifikasi</h5>
                    <div class="d-flex gap-2">
                        <form method="GET" class="d-flex gap-2">
                            <select class="form-select form-select-sm" name="jurusan_id" style="width: auto;">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold" style="color: #374151;">No. Pendaftaran</th>
                                <th class="border-0 fw-semibold" style="color: #374151;">Nama Lengkap</th>
                                <th class="border-0 fw-semibold" style="color: #374151;">Jurusan</th>
                                <th class="border-0 fw-semibold" style="color: #374151;">Tanggal Daftar</th>
                                <th class="border-0 fw-semibold" style="color: #374151;">Status Berkas</th>
                                <th class="border-0 fw-semibold" style="color: #374151;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftarans as $pendaftaran)
                            <tr>
                                <td class="fw-semibold text-primary">{{ $pendaftaran->nomor_pendaftaran }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($pendaftaran->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="color: #1e293b;">{{ $pendaftaran->nama_lengkap }}</div>
                                            <small style="color: #64748b;">{{ $pendaftaran->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $pendaftaran->jurusan->nama }}</span>
                                </td>
                                <td style="color: #64748b;">{{ $pendaftaran->created_at->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $requiredDocs = ['ijazah', 'rapor', 'kk', 'akta'];
                                        $uploadedRequired = $pendaftaran->berkas->whereIn('jenis', $requiredDocs)->count();
                                        $progress = ($uploadedRequired / 4) * 100;
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 8px;">
                                            <div class="progress-bar {{ $uploadedRequired == 4 ? 'bg-success' : 'bg-warning' }}" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <small style="color: #64748b;">{{ $uploadedRequired }}/4</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('verifikator.show', $pendaftaran) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success" title="Terima" 
                                                onclick="verifikasi({{ $pendaftaran->id }}, 'menunggu_bayar')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Tolak"
                                                onclick="tolak({{ $pendaftaran->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div style="color: #64748b;">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Tidak ada pendaftar yang menunggu verifikasi</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function verifikasi(id, status) {
    if(confirm('Yakin ingin menerima pendaftaran ini?')) {
        fetch(`/verifikator/${id}/verifikasi`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({status: status})
        }).then(() => location.reload());
    }
}

function tolak(id) {
    const catatan = prompt('Masukkan alasan penolakan:');
    if(catatan) {
        fetch(`/verifikator/${id}/tolak`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({catatan: catatan})
        }).then(() => location.reload());
    }
}
</script>
@endsection