@extends('layouts.verifikator')

@section('title', 'Verifikasi Berkas - SPMB SMK Bakti Nusantara 666')
@section('page-title', 'Verifikasi Berkas')
@section('page-subtitle', 'Verifikasi Administrasi Pendaftaran')

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
                    <h3 class="mb-0">{{ $pendaftarans->where('status', 'submitted')->count() }}</h3>
                    <p class="text-muted mb-0 d-none d-sm-block">Menunggu Verifikasi</p>
                    <p class="text-muted mb-0 d-sm-none small">Menunggu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3">
                        <i class="fas fa-check-circle text-success fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ $pendaftarans->where('status', 'valid')->count() }}</h3>
                    <p class="text-muted mb-0 d-none d-sm-block">Sudah Diverifikasi</p>
                    <p class="text-muted mb-0 d-sm-none small">Terverifikasi</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                        <i class="fas fa-times-circle text-danger fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ $pendaftarans->where('status', 'tidak_valid')->count() }}</h3>
                    <p class="text-muted mb-0">Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                        <i class="fas fa-list text-primary fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ $pendaftarans->count() }}</h3>
                    <p class="text-muted mb-0 d-none d-sm-block">Total Pendaftaran</p>
                    <p class="text-muted mb-0 d-sm-none small">Total</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="valid" {{ request('status') == 'valid' ? 'selected' : '' }}>Valid</option>
                    <option value="tidak_valid" {{ request('status') == 'tidak_valid' ? 'selected' : '' }}>Tidak Valid</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="jurusan" class="form-select">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ request('jurusan') == $jurusan->id ? 'selected' : '' }}>
                        {{ $jurusan->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pendaftaran Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Pendaftaran</h5>
    </div>
    <div class="card-body">
        @if($pendaftarans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Lengkap</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftarans as $pendaftaran)
                    <tr>
                        <td>
                            <span class="badge bg-primary">{{ $pendaftaran->nomor_pendaftaran }}</span>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $pendaftaran->nama_lengkap }}</strong>
                                <br>
                                <small class="text-muted">{{ $pendaftaran->user->name }}</small>
                            </div>
                        </td>
                        <td>{{ $pendaftaran->jurusan->nama ?? '-' }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'draft' => 'secondary',
                                    'submitted' => 'warning',
                                    'valid' => 'success',
                                    'tidak_valid' => 'danger',
                                    'lulus' => 'info'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusClass[$pendaftaran->status] ?? 'secondary' }}">
                                {{ $pendaftaran->getStatusLabelAttribute() }}
                            </span>
                        </td>
                        <td>
                            <small>{{ $pendaftaran->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm d-flex flex-column flex-md-row">
                                <a href="{{ route('verifikator.show', $pendaftaran) }}" class="btn btn-outline-primary mb-1 mb-md-0">
                                    <i class="fas fa-eye d-md-none"></i>
                                    <span class="d-none d-md-inline"><i class="fas fa-eye"></i> Detail</span>
                                    <span class="d-md-none">Detail</span>
                                </a>
                                @if($pendaftaran->status == 'submitted')
                                <button type="button" class="btn btn-outline-success mb-1 mb-md-0" onclick="verifikasi({{ $pendaftaran->id }}, 'valid')">
                                    <i class="fas fa-check d-md-none"></i>
                                    <span class="d-none d-md-inline"><i class="fas fa-check"></i> Terima</span>
                                    <span class="d-md-none">Terima</span>
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="showRejectModal({{ $pendaftaran->id }})">
                                    <i class="fas fa-times d-md-none"></i>
                                    <span class="d-none d-md-inline"><i class="fas fa-times"></i> Tolak</span>
                                    <span class="d-md-none">Tolak</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $pendaftarans->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox text-muted fs-1 mb-3"></i>
            <h5>Tidak Ada Data</h5>
            <p class="text-muted">Belum ada pendaftaran yang perlu diverifikasi.</p>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="catatan" class="form-control" rows="4" required placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function verifikasi(id, status) {
    if (confirm('Yakin ingin menerima pendaftaran ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/verifikator/${id}/verifikasi`;

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

function showRejectModal(id) {
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    document.getElementById('rejectForm').action = `/verifikator/${id}/tolak`;
    modal.show();
}
</script>
@endsection
