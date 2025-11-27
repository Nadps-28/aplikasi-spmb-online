@extends('layouts.verifikator')

@section('title', 'Detail Pendaftaran - SPMB SMK Bakti Nusantara 666')
@section('page-title', 'Detail Pendaftaran')
@section('page-subtitle', 'Verifikasi berkas dan data pendaftar')

@section('content')

    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold text-white mb-4">Detail Pendaftaran</h2>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Data Pendaftar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nomor Pendaftaran:</strong> {{ $pendaftaran->nomor_pendaftaran }}</p>
                            <p><strong>Nama Lengkap:</strong> {{ $pendaftaran->nama_lengkap }}</p>
                            <p><strong>NIK:</strong> {{ $pendaftaran->nik }}</p>
                            <p><strong>Email:</strong> {{ $pendaftaran->user->email }}</p>
                            <p><strong>Jurusan:</strong> {{ $pendaftaran->jurusan->nama }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tempat, Tanggal Lahir:</strong> {{ $pendaftaran->tempat_lahir }},
                                {{ $pendaftaran->tanggal_lahir->format('d F Y') }}</p>
                            <p><strong>Jenis Kelamin:</strong>
                                {{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            <p><strong>Asal Sekolah:</strong> {{ $pendaftaran->asal_sekolah }}</p>
                            <p><strong>Status:</strong>
                                <span
                                    class="badge bg-warning">{{ ucfirst(str_replace('_', ' ', $pendaftaran->status)) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Berkas yang Diupload</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Jenis Berkas</th>
                                    <th>Nama File</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaran->berkas as $berkas)
                                    <tr>
                                        <td>{{ ucfirst($berkas->jenis) }}</td>
                                        <td>{{ $berkas->nama_file }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $berkas->status == 'diterima' ? 'success' : 'warning' }}">
                                                {{ ucfirst($berkas->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ asset("storage/" . $berkas->path_file) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada berkas yang diupload</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Aksi Verifikasi</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('verifikator.verifikasi', $pendaftaran) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status Verifikasi</label>
                            <select class="form-select" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="menunggu_bayar">Terima - Lanjut ke Pembayaran</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Catatan verifikasi..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i> Terima Pendaftaran
                            </button>
                        </div>
                    </form>

                    <hr>

                    <form method="POST" action="{{ route('verifikator.tolak', $pendaftaran) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menolak pendaftaran ini?')">
                                <i class="fas fa-times me-2"></i> Tolak Pendaftaran
                            </button>
                        </div>
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('verifikator.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
