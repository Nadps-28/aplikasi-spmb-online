@extends('layouts.admin')

@section('title', 'Master Data - Admin Panel')
@section('page-title', 'Master Data Sistem')
@section('page-subtitle', 'Kelola data jurusan dan gelombang pendaftaran')

@section('content')
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-primary rounded-3 p-3 text-white">
                            <i class="fas fa-graduation-cap fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-gray-900">{{ $jurusans->count() }}</h3>
                        <p class="text-sm text-gray-600 mb-0">Total Jurusan</p>
                        <small class="text-success fw-semibold"><i class="fas fa-check-circle me-1"></i>{{ $jurusans->where('aktif', true)->count() }} Aktif</small>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 p-3">
                    <i class="fas fa-graduation-cap text-primary opacity-25 fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-success rounded-3 p-3 text-white">
                            <i class="fas fa-calendar-alt fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-gray-900">{{ $gelombangs->count() }}</h3>
                        <p class="text-sm text-gray-600 mb-0">Total Gelombang</p>
                        <small class="text-success fw-semibold"><i class="fas fa-play-circle me-1"></i>{{ $gelombangs->where('aktif', true)->count() }} Aktif</small>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 p-3">
                    <i class="fas fa-calendar-alt text-success opacity-25 fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.text-gray-900 { color: #111827; }
.text-gray-600 { color: #4b5563; }
.text-sm { font-size: 0.875rem; }
.opacity-25 { opacity: 0.25; }
</style>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-primary text-white rounded-3 d-flex align-items-center justify-content-center me-3" 
                         style="width: 56px; height: 56px;">
                        <i class="fas fa-graduation-cap fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1 text-gray-900">Manajemen Jurusan</h5>
                        <p class="text-gray-600 mb-0 small">Kelola program studi dan biaya pendaftaran</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.jurusan.store') }}" class="mb-4 p-4 bg-light bg-opacity-50 rounded-4 border">
                    @csrf
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-plus text-primary"></i>
                        </div>
                        <h6 class="fw-semibold mb-0 text-gray-900">Tambah Jurusan Baru</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium text-gray-700">Nama Jurusan</label>
                            <input type="text" class="form-control border-0 shadow-sm" name="nama" placeholder="Contoh: Teknik Komputer dan Jaringan" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium text-gray-700">Biaya Pendaftaran</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 shadow-sm">Rp</span>
                                <input type="number" class="form-control border-0 shadow-sm" name="biaya_daftar" placeholder="5500000" required>
                            </div>
                            <small class="text-gray-500"><i class="fas fa-info-circle me-1"></i>Sekolah swasta menerima siswa tanpa batasan kuota</small>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-plus me-2"></i>Tambah Jurusan
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem;">Program Keahlian</th>

                                <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem;">Biaya Daftar</th>
                                <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurusans as $jurusan)
                            <tr>
                                <td style="padding: 1rem;">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 35px; height: 35px; font-size: 0.8rem;">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div class="fw-semibold" style="color: #1e293b;">{{ $jurusan->nama }}</div>
                                    </div>
                                </td>

                                <td style="padding: 1rem;">
                                    <div class="fw-semibold" style="color: #1e293b;">Rp {{ number_format($jurusan->biaya_daftar, 0, ',', '.') }}</div>
                                </td>
                                <td style="padding: 1rem;">
                                    <span class="badge bg-{{ $jurusan->aktif ? 'success' : 'danger' }} px-3 py-2 rounded-pill">
                                        <i class="fas fa-{{ $jurusan->aktif ? 'check-circle' : 'times-circle' }} me-1"></i>
                                        {{ $jurusan->aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-graduation-cap fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                        <small>Belum ada data jurusan</small>
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
    
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-success text-white rounded-3 d-flex align-items-center justify-content-center me-3" 
                         style="width: 56px; height: 56px;">
                        <i class="fas fa-calendar-alt fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1 text-gray-900">Manajemen Gelombang</h5>
                        <p class="text-gray-600 mb-0 small">Atur periode dan jadwal pendaftaran</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.gelombang.store') }}" class="mb-4 p-4 bg-light bg-opacity-50 rounded-4 border">
                    @csrf
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="fas fa-plus text-success"></i>
                        </div>
                        <h6 class="fw-semibold mb-0 text-gray-900">Tambah Gelombang Baru</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium text-gray-700">Nama Gelombang</label>
                            <input type="text" class="form-control border-0 shadow-sm" name="nama" placeholder="Contoh: Gelombang 1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" class="form-control border-0 shadow-sm" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" class="form-control border-0 shadow-sm" name="tanggal_selesai" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="aktif" id="aktif" checked>
                                <label class="form-check-label fw-medium text-gray-700" for="aktif">
                                    <i class="fas fa-toggle-on me-1 text-success"></i>Aktifkan gelombang setelah dibuat
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success px-4 py-2">
                                <i class="fas fa-plus me-2"></i>Tambah Gelombang
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem;">Nama Gelombang</th>
                                <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem;">Periode</th>
                                <th class="border-0 fw-semibold" style="color: #374151; padding: 1rem;">Status & Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gelombangs as $gelombang)
                            <tr>
                                <td style="padding: 1rem;">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 35px; height: 35px; font-size: 0.8rem;">
                                            <i class="fas fa-wave-square"></i>
                                        </div>
                                        <div class="fw-semibold" style="color: #1e293b;">{{ $gelombang->nama }}</div>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div>
                                        <div class="fw-semibold" style="color: #1e293b; font-size: 0.9rem;">
                                            <i class="fas fa-calendar me-1 text-muted"></i>
                                            {{ $gelombang->tanggal_mulai->format('d/m/Y') }} - {{ $gelombang->tanggal_selesai->format('d/m/Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $gelombang->tanggal_mulai->diffInDays($gelombang->tanggal_selesai) }} hari
                                        </small>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-{{ $gelombang->aktif ? 'success' : 'danger' }} px-3 py-2 rounded-pill">
                                            <i class="fas fa-{{ $gelombang->aktif ? 'play-circle' : 'pause-circle' }} me-1"></i>
                                            {{ $gelombang->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                        <form method="POST" action="{{ route('admin.gelombang.toggle', $gelombang->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $gelombang->aktif ? 'danger' : 'success' }} rounded-pill px-3">
                                                <i class="fas fa-{{ $gelombang->aktif ? 'pause' : 'play' }} me-1"></i>
                                                {{ $gelombang->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar-alt fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                        <small>Belum ada data gelombang</small>
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