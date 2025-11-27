@extends('layouts.app')

@section('title', 'Dashboard Calon Siswa')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="student-dashboard-header mb-5">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-section">
                    <div class="student-badge mb-3">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Student Portal
                    </div>
                    <h1 class="display-5 fw-bold text-white mb-3">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="lead text-white-50 mb-0">Dashboard Calon Siswa - SMK Bakti Nusantara 666</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="student-info">
                    <div class="info-card">
                        <div class="info-date">
                            <div class="day">{{ now()->format('d') }}</div>
                            <div class="month">{{ now()->format('M Y') }}</div>
                        </div>
                        <div class="info-text">
                            <div class="greeting">{{ now()->format('l') }}</div>
                            <div class="status">{{ $pendaftaran ? 'Status: ' . ucfirst(str_replace('_', ' ', $pendaftaran->status)) : 'Belum Mendaftar' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.student-dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 3rem 0;
    margin: -2rem 0 0 0;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
}

.student-dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.student-badge {
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

.info-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(20px);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.info-date .day {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.info-date .month {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
    text-align: center;
}

.info-text .greeting {
    color: white;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.info-text .status {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
}
</style>

<div class="row">
    <div class="col-12">
        
        @if(!$pendaftaran)
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-rocket fa-4x text-primary mb-3"></i>
                        <h3 class="fw-bold mb-3" style="color: #1e293b;">Mulai Perjalanan Pendidikan Anda!</h3>
                        <p class="fs-5 mb-4" style="color: #64748b;">Anda belum melakukan pendaftaran. Klik tombol di bawah untuk memulai proses pendaftaran dan bergabung dengan ribuan calon mahasiswa lainnya.</p>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="card border-0 p-3 text-center" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(37, 99, 235, 0.05));">
                                        <i class="fas fa-clock text-primary mb-2 fa-2x"></i>
                                        <h6 class="fw-bold mb-1" style="color: #1e293b;">Cepat</h6>
                                        <small style="color: #64748b;">Proses 5 menit</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 p-3 text-center" style="background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(5, 150, 105, 0.05));">
                                        <i class="fas fa-shield-alt text-success mb-2 fa-2x"></i>
                                        <h6 class="fw-bold mb-1" style="color: #1e293b;">Aman</h6>
                                        <small style="color: #64748b;">Data terenkripsi</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 p-3 text-center" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));">
                                        <i class="fas fa-headset text-warning mb-2 fa-2x"></i>
                                        <h6 class="fw-bold mb-1" style="color: #1e293b;">Support</h6>
                                        <small style="color: #64748b;">Bantuan 24/7</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-3 fw-semibold" style="box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                        <i class="fas fa-rocket me-2"></i> Mulai Pendaftaran Sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0" style="color: #1e293b;">Timeline Pendaftaran</h5>
                                <span class="badge bg-{{ $pendaftaran->status == 'lulus' ? 'success' : ($pendaftaran->status == 'ditolak' ? 'danger' : 'warning') }} fs-6">
                                    {{ ucfirst(str_replace('_', ' ', $pendaftaran->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Timeline -->
                            <div class="timeline mb-4">
                                @php
                                    $currentStatus = $pendaftaran->status;
                                    $statusOrder = ['draft', 'submitted', 'valid', 'lunas', 'lulus'];
                                    $currentIndex = array_search($currentStatus, $statusOrder);
                                @endphp
                                
                                <div class="timeline-item {{ $currentIndex >= 1 ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1" style="color: #1e293b;">Pendaftaran Dikirim</h6>
                                        <small style="color: #64748b;">{{ $pendaftaran->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ $currentIndex >= 2 ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1" style="color: #1e293b;">Verifikasi Administrasi</h6>
                                        <small style="color: #64748b;">
                                            @if($currentIndex >= 2)
                                                Selesai diverifikasi - Berkas Valid
                                            @else
                                                Menunggu verifikasi
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ $currentIndex >= 3 ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1" style="color: #1e293b;">Lulus & Diterima</h6>
                                        <small style="color: #64748b;">
                                            @if($currentIndex >= 3)
                                                Selamat! Anda diterima sebagai siswa baru
                                            @elseif($currentIndex >= 2)
                                                Upload bukti pembayaran untuk diterima otomatis
                                            @else
                                                Belum sampai tahap ini
                                            @endif
                                        </small>
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
                                margin-bottom: 30px;
                            }
                            .timeline-marker {
                                position: absolute;
                                left: -23px;
                                top: 5px;
                                width: 16px;
                                height: 16px;
                                border-radius: 50%;
                                background: #e9ecef;
                                border: 3px solid #fff;
                                box-shadow: 0 0 0 3px #e9ecef;
                            }
                            .timeline-item.completed .timeline-marker {
                                background: #28a745;
                                box-shadow: 0 0 0 3px #28a745;
                            }
                            .timeline-item.completed::before {
                                background: #28a745;
                            }
                            </style>
                            <!-- Info Pendaftaran -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-id-card text-primary"></i>
                                        </div>
                                        <div>
                                            <small style="color: #64748b;">Nomor Pendaftaran</small>
                                            <div class="fw-bold" style="color: #1e293b;">{{ $pendaftaran->nomor_pendaftaran }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-graduation-cap text-success"></i>
                                        </div>
                                        <div>
                                            <small style="color: #64748b;">Jurusan Pilihan</small>
                                            <div class="fw-bold" style="color: #1e293b;">{{ $pendaftaran->jurusan->nama }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-calendar text-warning"></i>
                                        </div>
                                        <div>
                                            <small style="color: #64748b;">Gelombang</small>
                                            <div class="fw-bold" style="color: #1e293b;">{{ $pendaftaran->gelombang->nama }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-clock text-info"></i>
                                        </div>
                                        <div>
                                            <small style="color: #64748b;">Tanggal Daftar</small>
                                            <div class="fw-bold" style="color: #1e293b;">{{ $pendaftaran->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($pendaftaran->catatan_verifikasi)
                                <div class="border-top pt-4 mt-4">
                                    <div class="alert alert-{{ $pendaftaran->status == 'draft' ? 'warning' : 'info' }} d-flex align-items-start">
                                        <i class="fas fa-{{ $pendaftaran->status == 'draft' ? 'exclamation-triangle' : 'info-circle' }} me-3 mt-1"></i>
                                        <div>
                                            <h6 class="fw-bold mb-2">{{ $pendaftaran->status == 'draft' ? 'Catatan Penolakan' : 'Catatan Verifikasi' }}</h6>
                                            <p class="mb-0">{{ $pendaftaran->catatan_verifikasi }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($pendaftaran->catatan_kelulusan)
                                <div class="border-top pt-4 mt-4">
                                    <div class="alert alert-{{ $pendaftaran->status == 'lulus' ? 'success' : 'danger' }} d-flex align-items-start">
                                        <i class="fas fa-{{ $pendaftaran->status == 'lulus' ? 'check-circle' : 'times-circle' }} me-3 mt-1"></i>
                                        <div>
                                            <h6 class="fw-bold mb-2">{{ $pendaftaran->status == 'lulus' ? 'Catatan Kelulusan' : 'Catatan Penolakan Kelulusan' }}</h6>
                                            <p class="mb-0">{{ $pendaftaran->catatan_kelulusan }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($pendaftaran->status == 'draft')
                                <div class="border-top pt-4 mt-4">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="{{ route('pendaftaran.edit', $pendaftaran) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i> Edit Pendaftaran
                                        </a>
                                        <form method="POST" action="{{ route('pendaftaran.submit', $pendaftaran) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin mengirim pendaftaran?')">
                                                <i class="fas fa-paper-plane me-2"></i> Kirim Pendaftaran
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0 pb-0">
                            <h6 class="fw-bold mb-0" style="color: #1e293b;">Menu Cepat</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-3">
                                <a href="{{ route('berkas.index', $pendaftaran) }}" class="btn btn-outline-primary d-flex align-items-center">
                                    <i class="fas fa-file-upload me-3"></i>
                                    <div class="text-start">
                                        <div class="fw-semibold" style="color: #1e293b;">Upload Berkas</div>
                                        <small style="color: #64748b;">Kelola dokumen</small>
                                    </div>
                                </a>
                                
                                <a href="{{ route('pembayaran.show', $pendaftaran) }}" class="btn btn-outline-success d-flex align-items-center">
                                    <i class="fas fa-credit-card me-3"></i>
                                    <div class="text-start">
                                        <div class="fw-semibold" style="color: #1e293b;">Pembayaran</div>
                                        <small style="color: #64748b;">Status & upload bukti</small>
                                    </div>
                                </a>
                                
                                <a href="{{ route('pendaftaran.show', $pendaftaran) }}" class="btn btn-outline-info d-flex align-items-center">
                                    <i class="fas fa-print me-3"></i>
                                    <div class="text-start">
                                        <div class="fw-semibold" style="color: #1e293b;">Cetak Kartu</div>
                                        <small style="color: #64748b;">Download PDF</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Status Pembayaran -->
                            @php
                                $pembayaran = $pendaftaran->pembayaran;
                            @endphp
                            
                            <div class="mt-4">
                                <h6 class="fw-bold mb-3" style="color: #1e293b;">Status Pembayaran</h6>
                                
                                @if($pembayaran)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-{{ $pembayaran->status == 'verified' ? 'success' : ($pembayaran->status == 'rejected' ? 'danger' : 'warning') }} bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-{{ $pembayaran->status == 'verified' ? 'check-circle' : ($pembayaran->status == 'rejected' ? 'times-circle' : 'clock') }} text-{{ $pembayaran->status == 'verified' ? 'success' : ($pembayaran->status == 'rejected' ? 'danger' : 'warning') }}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="color: #1e293b;">{{ $pembayaran->status == 'verified' ? 'Terverifikasi' : ($pembayaran->status == 'rejected' ? 'Ditolak' : 'Menunggu Verifikasi') }}</div>
                                            @if($pembayaran->tanggal_bayar)
                                                <small style="color: #64748b;">{{ $pembayaran->tanggal_bayar->format('d M Y H:i') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($pembayaran->bukti_bayar)
                                        <div class="mb-3">
                                            <a href="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file me-2"></i> Lihat Bukti
                                            </a>
                                        </div>
                                    @endif
                                    
                                    @if($pembayaran->catatan)
                                        <div class="alert alert-{{ $pembayaran->status == 'rejected' ? 'danger' : 'info' }} alert-sm p-2">
                                            <small><strong>Catatan:</strong> {{ $pembayaran->catatan }}</small>
                                        </div>
                                    @endif
                                @else
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-exclamation-circle text-secondary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="color: #1e293b;">Belum Bayar</div>
                                            <small style="color: #64748b;">Silakan lakukan pembayaran</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4 p-3 bg-light rounded-3">
                                <h6 class="fw-bold mb-2" style="color: #1e293b;">Butuh Bantuan?</h6>
                                <p class="small mb-2" style="color: #64748b;">Tim support kami siap membantu Anda</p>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-headset me-1"></i> Hubungi Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection