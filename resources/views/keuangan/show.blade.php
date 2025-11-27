@extends('layouts.keuangan')

@section('title', 'Detail Pembayaran - SPMB SMK Bakti Nusantara 666')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', 'Verifikasi dan detail pembayaran siswa')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informasi Pendaftar</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="ps-0">Nomor Pendaftaran</td>
                                <td>:</td>
                                <td><span class="badge bg-primary">{{ $pembayaran->pendaftaran->nomor_pendaftaran }}</span></td>
                            </tr>
                            <tr>
                                <td class="ps-0">Nama Lengkap</td>
                                <td>:</td>
                                <td><strong>{{ $pembayaran->pendaftaran->nama_lengkap }}</strong></td>
                            </tr>
                            <tr>
                                <td class="ps-0">Username</td>
                                <td>:</td>
                                <td>{{ $pembayaran->pendaftaran->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0">Jurusan</td>
                                <td>:</td>
                                <td>{{ $pembayaran->pendaftaran->jurusan->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informasi Pembayaran</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="ps-0">Nominal</td>
                                <td>:</td>
                                <td><strong class="text-success">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td class="ps-0">Tanggal Upload</td>
                                <td>:</td>
                                <td>{{ $pembayaran->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0">Status</td>
                                <td>:</td>
                                <td>
                                    @if($pembayaran->status === 'pending')
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    @elseif($pembayaran->status === 'verified')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @if($pembayaran->catatan)
                            <tr>
                                <td class="ps-0">Catatan</td>
                                <td>:</td>
                                <td>{{ $pembayaran->catatan }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($pembayaran->bukti_bayar)
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Bukti Pembayaran</h6>
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" 
                             alt="Bukti Pembayaran" 
                             class="img-fluid rounded shadow"
                             style="max-height: 500px; cursor: pointer;"
                             onclick="showImageModal(this.src)">
                        <p class="text-muted mt-2 small">Klik gambar untuk memperbesar</p>
                    </div>
                </div>
                @else
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Bukti Pembayaran</h6>
                    <div class="text-center py-4">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada bukti pembayaran yang diupload</p>
                    </div>
                </div>
                @endif

                @if($pembayaran->status === 'pending')
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-success" onclick="verifikasiPembayaran('verified')">
                        <i class="fas fa-check me-1"></i>Terima Pembayaran
                    </button>
                    <button type="button" class="btn btn-danger" onclick="verifikasiPembayaran('rejected')">
                        <i class="fas fa-times me-1"></i>Tolak Pembayaran
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Status Pendaftaran</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item {{ $pembayaran->pendaftaran->status !== 'draft' ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Pendaftaran Dibuat</h6>
                            <small class="text-muted">{{ $pembayaran->pendaftaran->created_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ in_array($pembayaran->pendaftaran->status, ['submitted', 'valid', 'lulus']) ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Berkas Disubmit</h6>
                            <small class="text-muted">
                                {{ $pembayaran->pendaftaran->submitted_at ? (is_string($pembayaran->pendaftaran->submitted_at) ? \Carbon\Carbon::parse($pembayaran->pendaftaran->submitted_at)->format('d M Y H:i') : $pembayaran->pendaftaran->submitted_at->format('d M Y H:i')) : '-' }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ in_array($pembayaran->pendaftaran->status, ['valid', 'lulus']) ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Berkas Terverifikasi</h6>
                            <small class="text-muted">
                                {{ $pembayaran->pendaftaran->verified_at ? (is_string($pembayaran->pendaftaran->verified_at) ? \Carbon\Carbon::parse($pembayaran->pendaftaran->verified_at)->format('d M Y H:i') : $pembayaran->pendaftaran->verified_at->format('d M Y H:i')) : '-' }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $pembayaran->status === 'verified' ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Pembayaran Terverifikasi</h6>
                            <small class="text-muted">
                                {{ $pembayaran->status === 'verified' && $pembayaran->updated_at ? $pembayaran->updated_at->format('d M Y H:i') : '-' }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $pembayaran->pendaftaran->status === 'lulus' ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Diterima (Lulus)</h6>
                            <small class="text-muted">
                                {{ $pembayaran->pendaftaran->graduated_at ? (is_string($pembayaran->pendaftaran->graduated_at) ? \Carbon\Carbon::parse($pembayaran->pendaftaran->graduated_at)->format('d M Y H:i') : $pembayaran->pendaftaran->graduated_at->format('d M Y H:i')) : '-' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard.keuangan') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                    </a>
                    <a href="{{ route('export.keuangan') }}" class="btn btn-outline-success">
                        <i class="fas fa-download me-1"></i>Export Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e9ecef;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-item.completed .timeline-marker {
    background: #f59e0b;
    box-shadow: 0 0 0 2px #f59e0b;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-size: 14px;
}

.timeline-item.completed .timeline-content h6 {
    color: #f59e0b;
    font-weight: 600;
}
</style>
@endsection

@section('scripts')
<script>
function showImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function verifikasiPembayaran(status) {
    const statusText = status === 'verified' ? 'menerima' : 'menolak';
    
    if (confirm(`Yakin ingin ${statusText} pembayaran ini?`)) {
        fetch('/keuangan/{{ $pembayaran->id }}/verifikasi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses verifikasi');
        });
    }
}
</script>
@endsection