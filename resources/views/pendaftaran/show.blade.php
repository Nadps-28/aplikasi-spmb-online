@extends('layouts.app')

@section('title', 'Kartu Pendaftaran')

@section('content')
<div class="container-fluid">
    @include('layouts.back-button', ['backUrl' => route('dashboard'), 'backText' => 'Kembali ke Dashboard'])
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="fw-bold mb-0">KARTU PENDAFTARAN SPMB</h4>
                <p class="mb-0">Sistem Penerimaan Mahasiswa Baru</p>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="200"><strong>Nomor Pendaftaran</strong></td>
                                <td>: {{ $pendaftaran->nomor_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>: {{ $pendaftaran->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td>: {{ $pendaftaran->nik }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat, Tanggal Lahir</strong></td>
                                <td>: {{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>: {{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Agama</strong></td>
                                <td>: {{ $pendaftaran->agama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>: {{ $pendaftaran->alamat }}, {{ $pendaftaran->kelurahan }}, {{ $pendaftaran->kecamatan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Asal Sekolah</strong></td>
                                <td>: {{ $pendaftaran->asal_sekolah }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jurusan Pilihan</strong></td>
                                <td>: {{ $pendaftaran->jurusan->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gelombang</strong></td>
                                <td>: {{ $pendaftaran->gelombang->nama }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3 bg-light">
                            @php
                                $pasFoto = $pendaftaran->berkas()->where('jenis', 'pas_foto')->first();
                            @endphp
                            @if($pasFoto)
                                <img src="{{ asset("storage/" . $pasFoto->path_file) }}" 
                                     alt="Pas Foto" 
                                     class="img-fluid rounded" 
                                     style="max-width: 120px; max-height: 160px; object-fit: cover;">
                            @else
                                <i class="fas fa-user fa-5x text-muted mb-3"></i>
                                <p class="small text-muted">Foto 3x4</p>
                            @endif
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-{{ $pendaftaran->status == 'lulus' ? 'success' : 'warning' }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $pendaftaran->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="border-top pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Data Orang Tua/Wali:</h6>
                            <p class="mb-1"><strong>Ayah:</strong> {{ $pendaftaran->nama_ayah }} ({{ $pendaftaran->pekerjaan_ayah }})</p>
                            <p class="mb-1"><strong>Ibu:</strong> {{ $pendaftaran->nama_ibu }} ({{ $pendaftaran->pekerjaan_ibu }})</p>
                            @if($pendaftaran->nama_wali)
                                <p class="mb-1"><strong>Wali:</strong> {{ $pendaftaran->nama_wali }} ({{ $pendaftaran->pekerjaan_wali }})</p>
                            @endif
                            <p class="mb-0"><strong>No. HP:</strong> {{ $pendaftaran->phone_ortu }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Informasi Pendaftaran:</h6>
                            <p class="mb-1"><strong>Tanggal Daftar:</strong> {{ $pendaftaran->created_at->format('d F Y') }}</p>
                            <p class="mb-1"><strong>Biaya Pendaftaran:</strong> Rp {{ number_format($pendaftaran->jurusan->biaya_daftar, 0, ',', '.') }}</p>
                            <p class="mb-0"><strong>Email:</strong> {{ $pendaftaran->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-light">
                <p class="small text-muted mb-2">Kartu ini adalah bukti sah pendaftaran. Harap disimpan dengan baik.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i> Cetak Kartu
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .navbar, .card-footer {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection