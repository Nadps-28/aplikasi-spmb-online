@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="container-fluid">
    @include('layouts.back-button', ['backUrl' => route('kepala-sekolah.kelulusan'), 'backText' => 'Kembali ke Kelulusan'])
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-bold mb-0" style="color: #1e293b;">Detail Siswa</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <div class="bg-gradient-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 1.5rem; font-weight: 600;">
                        {{ strtoupper(substr($pendaftaran->nama_lengkap, 0, 2)) }}
                    </div>
                    <h5 class="fw-bold">{{ $pendaftaran->nama_lengkap }}</h5>
                    <p class="text-muted mb-0">{{ $pendaftaran->nomor_pendaftaran }}</p>
                </div>
            </div>
    <div class="col-md-8">
        <div class="row g-3">
            <div class="col-6">
                <label class="form-label fw-semibold text-muted">Email</label>
                <p class="mb-0">{{ $pendaftaran->user->email }}</p>
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold text-muted">Jurusan</label>
                <p class="mb-0">{{ $pendaftaran->jurusan->nama }}</p>
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold text-muted">Jenis Kelamin</label>
                <p class="mb-0">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold text-muted">Tempat, Tanggal Lahir</label>
                <p class="mb-0">{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir->format('d M Y') }}</p>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold text-muted">Alamat</label>
                <p class="mb-0">{{ $pendaftaran->alamat }}</p>
                <small class="text-muted">{{ $pendaftaran->kecamatan }}, {{ $pendaftaran->kelurahan }} - {{ $pendaftaran->kodepos }}</small>
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<div class="row">
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">Data Orang Tua</h6>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold text-muted">Nama Ayah</label>
                <p class="mb-0">{{ $pendaftaran->nama_ayah }}</p>
                <small class="text-muted">{{ $pendaftaran->pekerjaan_ayah }}</small>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold text-muted">Nama Ibu</label>
                <p class="mb-0">{{ $pendaftaran->nama_ibu }}</p>
                <small class="text-muted">{{ $pendaftaran->pekerjaan_ibu }}</small>
            </div>
            @if($pendaftaran->nama_wali)
            <div class="col-12">
                <label class="form-label fw-semibold text-muted">Nama Wali</label>
                <p class="mb-0">{{ $pendaftaran->nama_wali }}</p>
                <small class="text-muted">{{ $pendaftaran->pekerjaan_wali }}</small>
            </div>
            @endif
            <div class="col-12">
                <label class="form-label fw-semibold text-muted">No. Telepon</label>
                <p class="mb-0">{{ $pendaftaran->phone_ortu }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">Status Pembayaran</h6>
        @if($pendaftaran->pembayaran)
        <div class="card bg-success-subtle border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                    <div>
                        <h6 class="mb-1 text-success">Pembayaran Lunas</h6>
                        <p class="mb-0 small">Rp {{ number_format($pendaftaran->pembayaran->nominal, 0, ',', '.') }}</p>
                        <small class="text-muted">{{ $pendaftaran->pembayaran->updated_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card bg-warning-subtle border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-warning fa-2x me-3"></i>
                    <div>
                        <h6 class="mb-1 text-warning">Belum Bayar</h6>
                        <p class="mb-0 small">Menunggu pembayaran</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <h6 class="fw-bold mb-3 mt-4">Berkas Dokumen</h6>
        <div class="list-group list-group-flush">
            @forelse($pendaftaran->berkas as $berkas)
            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                <div>
                    <i class="fas fa-file-alt text-primary me-2"></i>
                    {{ ucfirst(str_replace('_', ' ', $berkas->jenis_berkas)) }}
                </div>
                <span class="badge bg-success">✓</span>
            </div>
            @empty
            <div class="list-group-item px-0">
                <small class="text-muted">Belum ada berkas yang diupload</small>
            </div>
            @endforelse
        </div>
    </div>
</div>
    </div>
</div>
@endsection