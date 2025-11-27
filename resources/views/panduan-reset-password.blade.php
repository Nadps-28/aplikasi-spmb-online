@extends('layouts.app')

@section('title', 'Panduan Reset Password - SPMB')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 20px; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                            <i class="fas fa-shield-alt fa-2x text-white"></i>
                        </div>
                        <h2 class="fw-bold mb-3 text-dark">Panduan Reset Password</h2>
                        <p class="text-muted">Ikuti langkah-langkah berikut untuk mereset password dengan sistem OTP</p>
                    </div>

                <div class="row">
                    <div class="col-12">
                        <!-- Step 1 -->
                        <div class="d-flex align-items-start mb-4 p-4 rounded-4" style="background: rgba(102, 126, 234, 0.1); border-left: 4px solid #667eea;">
                            <div class="flex-shrink-0 me-4">
                                <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%;">
                                    <span class="fw-bold text-white">1</span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-2 text-dark">Kirim Kode OTP</h5>
                                <p class="mb-3 text-muted">Jika Anda lupa password, ikuti langkah berikut:</p>
                                <ul class="mb-3 text-dark">
                                    <li>Masuk ke halaman <strong>Login</strong></li>
                                    <li>Klik link <strong>"Lupa password?"</strong> di bawah form login</li>
                                    <li>Masukkan <strong>Email</strong> yang Anda gunakan saat mendaftar</li>
                                    <li>Klik tombol <strong>"Kirim Kode OTP"</strong></li>
                                    <li>Kode OTP 6 digit akan dikirim ke email Anda</li>
                                </ul>
                                <div class="alert alert-info border-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Penting:</strong> Pastikan email yang dimasukkan sama dengan yang digunakan saat mendaftar
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="d-flex align-items-start mb-4 p-4 rounded-4" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981;">
                            <div class="flex-shrink-0 me-4">
                                <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%;">
                                    <span class="fw-bold text-white">2</span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-2 text-dark">Verifikasi Kode OTP</h5>
                                <p class="mb-3 text-muted">Setelah menerima email OTP, ikuti langkah berikut:</p>
                                <ul class="mb-3 text-dark">
                                    <li>Buka email Anda dan cari email dari sistem SPMB</li>
                                    <li>Salin <strong>kode OTP 6 digit</strong> dari email</li>
                                    <li>Masukkan kode OTP di halaman verifikasi</li>
                                    <li>Klik tombol <strong>"Verifikasi OTP"</strong></li>
                                    <li>Jika OTP benar, Anda akan diarahkan ke form reset password</li>
                                </ul>
                                <div class="alert alert-warning border-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Catatan:</strong> Kode OTP berlaku selama 10 menit. Jika expired, kirim ulang OTP
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="d-flex align-items-start mb-4 p-4 rounded-4" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b;">
                            <div class="flex-shrink-0 me-4">
                                <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%;">
                                    <span class="fw-bold text-white">3</span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-2 text-dark">Buat Password Baru</h5>
                                <p class="mb-3 text-muted">Setelah OTP terverifikasi, buat password baru:</p>
                                <ul class="mb-3 text-dark">
                                    <li>Masukkan <strong>password baru</strong> (minimal 8 karakter)</li>
                                    <li>Masukkan <strong>konfirmasi password</strong> (harus sama dengan password baru)</li>
                                    <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                                    <li>Klik tombol <strong>"Update Password"</strong></li>
                                    <li>Password berhasil diperbarui, login dengan password baru</li>
                                </ul>
                                <div class="alert alert-success border-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Selesai!</strong> Anda sekarang bisa login dengan password baru
                                </div>
                            </div>
                        </div>

                        <!-- Tips -->
                        <div class="mt-5 p-4 rounded-4" style="background: rgba(102, 126, 234, 0.05); border: 1px solid rgba(102, 126, 234, 0.2);">
                            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-lightbulb me-2 text-warning"></i> Tips Penting</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="mb-0 text-dark">
                                        <li class="mb-2">Gunakan email yang sama di semua langkah</li>
                                        <li class="mb-2">Kode OTP berlaku selama 10 menit</li>
                                        <li class="mb-2">Password baru minimal 8 karakter</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="mb-0 text-dark">
                                        <li class="mb-2">Jangan bagikan kode OTP ke orang lain</li>
                                        <li class="mb-2">Periksa folder spam jika email tidak masuk</li>
                                        <li class="mb-2">Simpan password baru di tempat yang aman</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Troubleshooting -->
                        <div class="mt-4 p-4 rounded-4" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2);">
                            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-tools me-2 text-danger"></i> Jika Mengalami Masalah</h5>
                            <div class="accordion" id="troubleshootingAccordion">
                                <div class="accordion-item bg-transparent border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-transparent text-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#problem1">
                                            Email tidak ditemukan
                                        </button>
                                    </h6>
                                    <div id="problem1" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body text-muted">
                                            <p>Pastikan email yang dimasukkan sama persis dengan yang digunakan saat mendaftar. Cek kembali penulisan dan pastikan tidak ada spasi atau karakter tambahan.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item bg-transparent border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-transparent text-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#problem2">
                                            Email OTP tidak masuk
                                        </button>
                                    </h6>
                                    <div id="problem2" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body text-muted">
                                            <p>Periksa folder spam/junk email Anda. Jika masih tidak ada, tunggu beberapa menit atau kirim ulang OTP dengan mengklik tombol "Kirim Ulang OTP".</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item bg-transparent border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-transparent text-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#problem3">
                                            Kode OTP tidak valid
                                        </button>
                                    </h6>
                                    <div id="problem3" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body text-muted">
                                            <p>Pastikan kode OTP dimasukkan dengan benar (6 digit). Jika OTP sudah expired (lebih dari 10 menit), kirim ulang OTP baru.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="text-center mt-5">
                        <div class="d-flex flex-column flex-md-row justify-content-center gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Ke Halaman Login
                            </a>
                            <a href="{{ route('password.request') }}" class="btn btn-success">
                                <i class="fas fa-key me-2"></i> Reset Password
                            </a>
                            <a href="{{ route('password.verify.form') }}" class="btn btn-outline-primary">
                                <i class="fas fa-shield-alt me-2"></i> Verifikasi OTP
                            </a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection