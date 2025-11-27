@extends('layouts.admin')

@section('title', 'Monitoring Berkas - Admin Panel')
@section('page-title', 'Monitoring Berkas')
@section('page-subtitle', 'Pantau kelengkapan berkas dan status verifikasi pendaftar')

@section('content')
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-primary rounded-3 p-3 text-white">
                            <i class="fas fa-users fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-gray-900">{{ $pendaftarans->count() }}</h3>
                        <p class="text-sm text-gray-600 mb-0">Total Pendaftar</p>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 p-3">
                    <i class="fas fa-users text-primary opacity-25 fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-success rounded-3 p-3 text-white">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-gray-900">{{ $pendaftarans->where('status', 'lulus')->count() }}</h3>
                        <p class="text-sm text-gray-600 mb-0">Lulus</p>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 p-3">
                    <i class="fas fa-check-circle text-success opacity-25 fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-warning rounded-3 p-3 text-white">
                            <i class="fas fa-clock fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-gray-900">{{ $pendaftarans->where('status', 'submitted')->count() }}</h3>
                        <p class="text-sm text-gray-600 mb-0">Menunggu</p>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 p-3">
                    <i class="fas fa-clock text-warning opacity-25 fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-danger rounded-3 p-3 text-white">
                            <i class="fas fa-times-circle fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-gray-900">{{ $pendaftarans->where('status', 'tidak_valid')->count() }}</h3>
                        <p class="text-sm text-gray-600 mb-0">Ditolak</p>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 p-3">
                    <i class="fas fa-times-circle text-danger opacity-25 fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.bg-gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
.text-gray-900 { color: #111827; }
.text-gray-600 { color: #4b5563; }
.text-sm { font-size: 0.875rem; }
.opacity-25 { opacity: 0.25; }
.dropdown-item.active {
    background-color: #3b82f6;
    color: white;
}
.dropdown-item.active:hover {
    background-color: #2563eb;
    color: white;
}
</style>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pb-0">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <div>
                <h5 class="fw-bold mb-1 text-gray-900">Daftar Pendaftar & Status Berkas</h5>
                <p class="text-gray-600 mb-0 small">Monitoring kelengkapan berkas dan status verifikasi pendaftar ({{ $pendaftarans->total() }} data)</p>

            </div>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" id="statusFilterBtn">
                        <i class="fas fa-filter me-1"></i> 
                        <span id="filterText">
                            @if(request('status') == 'lulus') Lulus
                            @elseif(request('status') == 'submitted') Menunggu
                            @elseif(request('status') == 'tidak_valid') Ditolak
                            @elseif(request('status') == 'valid') Terverifikasi
                            @else Semua Status
                            @endif
                        </span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ !request('status') || request('status') == 'all' ? 'active' : '' }}" href="{{ route('admin.monitoring') }}">Semua Status</a></li>
                        <li><a class="dropdown-item {{ request('status') == 'submitted' ? 'active' : '' }}" href="{{ route('admin.monitoring', ['status' => 'submitted']) }}">Menunggu Verifikasi</a></li>
                        <li><a class="dropdown-item {{ request('status') == 'valid' ? 'active' : '' }}" href="{{ route('admin.monitoring', ['status' => 'valid']) }}">Terverifikasi</a></li>
                        <li><a class="dropdown-item {{ request('status') == 'lulus' ? 'active' : '' }}" href="{{ route('admin.monitoring', ['status' => 'lulus']) }}">Lulus</a></li>
                        <li><a class="dropdown-item {{ request('status') == 'tidak_valid' ? 'active' : '' }}" href="{{ route('admin.monitoring', ['status' => 'tidak_valid']) }}">Ditolak</a></li>
                    </ul>
                </div>
                <a href="{{ route('export.pendaftar') }}" class="btn btn-success" 
                   onclick="console.log('Export button clicked'); return true;">
                    <i class="fas fa-download me-2"></i>Export Excel
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem; font-size: 0.85rem;">No. Pendaftaran</th>
                        <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem; font-size: 0.85rem;">Data Pendaftar</th>
                        <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem; font-size: 0.85rem;">Program Keahlian</th>
                        <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem; font-size: 0.85rem;">Status</th>
                        <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem; font-size: 0.85rem;">Berkas</th>
                        <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem; font-size: 0.85rem;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $pendaftaran)
                    <tr style="transition: all 0.2s ease;">
                        <td style="padding: 1rem;">
                            <div class="fw-bold text-primary">{{ $pendaftaran->nomor_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td style="padding: 1rem;">
                            <div class="d-flex align-items-center">
                                <div class="bg-gradient-primary text-white rounded-3 d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px; font-size: 0.9rem; font-weight: 700;">
                                    {{ strtoupper(substr($pendaftaran->nama_lengkap ?? 'N', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-gray-900" style="font-size: 0.9rem;">
                                        {{ $pendaftaran->nama_lengkap ?? ($pendaftaran->user ? $pendaftaran->user->name : 'Nama tidak tersedia') }}
                                    </div>
                                    <small class="text-gray-500">
                                        <i class="fas fa-envelope me-1"></i>{{ $pendaftaran->user->email ?? 'Email tidak tersedia' }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem;">
                            <span class="badge bg-success text-white px-2 py-1 rounded-pill fw-medium" style="font-size: 0.75rem;">
                                <i class="fas fa-laptop-code me-1"></i>
                                {{ $pendaftaran->jurusan ? $pendaftaran->jurusan->nama : 'Belum memilih jurusan' }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            @php
                                $statusConfig = [
                                    'draft' => ['color' => 'secondary', 'icon' => 'edit', 'text' => 'Draft'],
                                    'submitted' => ['color' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu'],
                                    'valid' => ['color' => 'info', 'icon' => 'check', 'text' => 'Terverifikasi'],
                                    'tidak_valid' => ['color' => 'danger', 'icon' => 'times-circle', 'text' => 'Ditolak'],
                                    'lulus' => ['color' => 'success', 'icon' => 'graduation-cap', 'text' => 'Lulus'],
                                    'belum_bayar' => ['color' => 'warning', 'icon' => 'credit-card', 'text' => 'Belum Bayar']
                                ];
                                $config = $statusConfig[$pendaftaran->status] ?? ['color' => 'secondary', 'icon' => 'question', 'text' => ucfirst($pendaftaran->status)];
                            @endphp
                            <span class="badge bg-{{ $config['color'] }} px-2 py-1 rounded-pill fw-medium" style="font-size: 0.75rem;">
                                <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                {{ $config['text'] }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <div class="d-flex align-items-center">
                                @php
                                    $requiredDocs = $pendaftaran->berkas ? $pendaftaran->berkas->whereIn('jenis', ['ijazah', 'rapor', 'kk', 'akta'])->count() : 0;
                                    $percentage = ($requiredDocs / 4) * 100;
                                @endphp
                                <div class="progress me-2" style="width: 80px; height: 8px; border-radius: 6px;">
                                    <div class="progress-bar bg-{{ $percentage >= 100 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger') }}" 
                                         style="width: {{ $percentage }}%; border-radius: 6px;"></div>
                                </div>
                                <span class="fw-medium text-gray-900" style="font-size: 0.8rem;">{{ $requiredDocs }}/4</span>
                            </div>
                        </td>
                        <td style="padding: 1rem;">
                            <div class="text-gray-600" style="font-size: 0.85rem;">
                                <div class="fw-medium">{{ $pendaftaran->created_at->format('d/m/Y') }}</div>
                                <small class="text-gray-500">{{ $pendaftaran->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                <h6 class="fw-semibold">Belum Ada Data Pendaftar</h6>
                                <p class="mb-0 small">Data pendaftar akan muncul setelah ada yang mendaftar</p>
                                @if(request('status'))
                                    <p class="mb-0 small text-info">Filter aktif: {{ request('status') }}</p>
                                    <a href="{{ route('admin.monitoring') }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Semua Data</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pendaftarans->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $pendaftarans->links() }}
    </div>
    @endif
</div>
@endsection