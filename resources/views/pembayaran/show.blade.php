@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container-fluid">
    @include('layouts.back-button', ['backUrl' => route('dashboard'), 'backText' => 'Kembali ke Dashboard'])
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Pembayaran Pendaftaran</h4>
                <p class="mb-0">Nomor Pendaftaran: {{ $pendaftaran->nomor_pendaftaran }}</p>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Detail Pembayaran:</h6>
                        <p><strong>Jurusan:</strong> {{ $pendaftaran->jurusan->nama }}</p>
                        <p><strong>Biaya Pendaftaran:</strong> Rp {{ number_format($pendaftaran->jurusan->biaya_daftar, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status Pembayaran:</h6>
                        @if($pembayaran)
                            <span class="badge bg-{{ $pembayaran->status == 'verified' ? 'success' : ($pembayaran->status == 'rejected' ? 'danger' : 'warning') }} fs-6">
                                @if($pembayaran->status == 'verified')
                                    Terverifikasi
                                @elseif($pembayaran->status == 'rejected')
                                    Ditolak
                                @else
                                    Menunggu Verifikasi
                                @endif
                            </span>
                            @if($pembayaran->tanggal_bayar)
                                <p class="mt-2"><small>Tanggal: {{ $pembayaran->tanggal_bayar->format('d/m/Y H:i') }}</small></p>
                            @endif
                        @else
                            <span class="badge bg-secondary fs-6">Belum Bayar</span>
                        @endif
                    </div>
                </div>

                @if($pendaftaran->status == 'valid' || ($pembayaran && $pembayaran->status == 'rejected'))
                <div class="alert alert-info">
                    <h6>Instruksi Pembayaran:</h6>
                    <p>1. Transfer ke rekening: <strong>BCA 1234567890 a.n. Yayasan Pendidikan</strong></p>
                    <p>2. Nominal: <strong>Rp {{ number_format($pendaftaran->jurusan->biaya_daftar, 0, ',', '.') }}</strong></p>
                    <p>3. Berita transfer: <strong>{{ $pendaftaran->nomor_pendaftaran }}</strong></p>
                    <p>4. Upload bukti transfer di bawah ini</p>
                </div>
                @elseif(in_array($pendaftaran->status, ['draft', 'submitted']))
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Menunggu Verifikasi Administrasi</h6>
                    <p class="mb-0">Pembayaran hanya dapat dilakukan setelah pendaftaran Anda diverifikasi oleh tim administrasi. Silakan tunggu konfirmasi lebih lanjut.</p>
                </div>
                @endif

                @if($pendaftaran->catatan_verifikasi)
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Catatan Verifikasi</h6>
                    <p class="mb-0">{{ $pendaftaran->catatan_verifikasi }}</p>
                </div>
                @endif

                @if($pendaftaran->status == 'valid' || ($pembayaran && $pembayaran->status == 'rejected'))
                <form method="POST" action="{{ route('pembayaran.upload', $pendaftaran) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control @error('bukti_bayar') is-invalid @enderror" 
                               name="bukti_bayar" accept=".pdf,.jpg,.jpeg,.png" required>
                        @error('bukti_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: PDF, JPG, PNG. Maksimal 2MB</small>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                    </button>
                </form>
                @endif

                @if($pembayaran && $pembayaran->bukti_bayar)
                <div class="mt-4">
                    <h6>Bukti Pembayaran:</h6>
                    <div class="border p-3 rounded">
                        <a href="{{ asset("storage/" . $pembayaran->bukti_bayar) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-file"></i> Lihat Bukti Pembayaran
                        </a>
                        @if($pembayaran->catatan)
                            <div class="mt-2">
                                <small class="text-muted">Catatan: {{ $pembayaran->catatan }}</small>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Timeline Status</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @php
                        $currentStatus = $pendaftaran->status;
                        $statusOrder = ['draft', 'submitted', 'valid', 'lulus'];
                        $currentIndex = array_search($currentStatus, $statusOrder);
                    @endphp
                    
                    <div class="timeline-item {{ $currentIndex >= 0 ? 'completed' : '' }}">
                        <i class="fas fa-edit"></i> Draft
                        @if($currentStatus == 'draft')<span class="badge bg-secondary ms-2">Saat ini</span>@endif
                    </div>
                    <div class="timeline-item {{ $currentIndex >= 1 ? 'completed' : '' }}">
                        <i class="fas fa-paper-plane"></i> Dikirim
                        @if($currentStatus == 'submitted')<span class="badge bg-warning ms-2">Saat ini</span>@endif
                    </div>
                    <div class="timeline-item {{ $currentIndex >= 2 ? 'completed' : '' }}">
                        <i class="fas fa-check"></i> Berkas Valid
                        @if($currentStatus == 'valid')<span class="badge bg-info ms-2">Saat ini</span>@endif
                    </div>
                    <div class="timeline-item {{ $currentIndex >= 3 ? 'completed' : '' }}">
                        <i class="fas fa-graduation-cap"></i> Lulus & Diterima
                        @if($currentStatus == 'lulus')<span class="badge bg-success ms-2">Saat ini</span>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding: 10px 0;
    border-left: 2px solid #dee2e6;
    padding-left: 20px;
    margin-bottom: 10px;
}

.timeline-item.completed {
    border-left-color: #28a745;
    color: #28a745;
}

.timeline-item i {
    position: absolute;
    left: -8px;
    background: white;
    border: 2px solid #dee2e6;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
}

.timeline-item.completed i {
    border-color: #28a745;
    color: #28a745;
}
</style>
@endsection