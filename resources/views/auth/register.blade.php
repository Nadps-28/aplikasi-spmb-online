@extends('layouts.app')

@section('title', 'Registrasi - SPMB')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 2rem 1rem; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); position: relative;">
    <div class="position-absolute w-100 h-100" style="background-image: radial-gradient(circle at 20% 80%, rgba(37, 99, 235, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(5, 150, 105, 0.1) 0%, transparent 50%), radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.05) 0%, transparent 50%); opacity: 0.8;"></div>
    <div class="w-100 position-relative" style="max-width: 900px; z-index: 1;">
        <div class="row g-0 shadow-lg rounded-4 overflow-hidden bg-white">
            <!-- Left Side - Registration Steps -->
            <div class="col-md-6 d-none d-md-block position-relative">
                <div class="h-100 d-flex align-items-center justify-content-center position-relative" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); overflow: hidden; min-height: 450px;">
                    <div class="text-center text-white p-3 position-relative">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.2); border-radius: 20px;">
                                <i class="fas fa-rocket fa-2x" style="color: white;"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Mulai Perjalanan</h5>
                            <p class="mb-3 small">Bergabung dengan calon murid sukses</p>
                        </div>
                        
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="bg-white bg-opacity-20 rounded-3 p-2 mb-2">
                                    <i class="fas fa-mouse-pointer" style="color: #fbbf24;"></i>
                                </div>
                                <small>Daftar Online</small>
                            </div>
                            <div class="col-4">
                                <div class="bg-white bg-opacity-20 rounded-3 p-2 mb-2">
                                    <i class="fas fa-cloud-upload-alt" style="color: #10b981;"></i>
                                </div>
                                <small>Upload Mudah</small>
                            </div>
                            <div class="col-4">
                                <div class="bg-white bg-opacity-20 rounded-3 p-2 mb-2">
                                    <i class="fas fa-wallet" style="color: #f87171;"></i>
                                </div>
                                <small>Bayar Fleksibel</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Registration Form -->
            <div class="col-md-6">
                <div class="p-4 h-100 d-flex align-items-center" style="background: white; min-height: 450px;">
                    <div class="w-100">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background-color: #2563eb; border-radius: 20px;">
                            <i class="fas fa-rocket fa-2x text-white"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1e293b;">Buat Akun Baru</h4>
                        <p class="mb-0" style="color: #64748b;">Daftar dengan 3 langkah mudah</p>
                        <div class="d-flex justify-content-center mt-3 gap-2">
                            <span class="badge bg-primary">1. Isi Data</span>
                            <span class="badge bg-light text-dark">2. Verifikasi Email</span>
                            <span class="badge bg-light text-dark">3. Selesai</span>
                        </div>
                    </div>
        
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color: #374151;">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color: #374151;">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                               name="username" value="{{ old('username') }}" placeholder="Masukkan username" required>
                        @error('username')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Username akan digunakan untuk login</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color: #374151;">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color: #374151;">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" class="form-control border-end-0 @error('password') is-invalid @enderror" 
                                       name="password" placeholder="Min 8 karakter" required style="border-radius: 8px 0 0 8px;">
                                <span class="input-group-text bg-light border-start-0 cursor-pointer"
                                    style="border-radius: 0 8px 8px 0;" onclick="togglePassword('password')">
                                    <i class="fas fa-eye text-muted" id="password-toggle"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color: #374151;">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" id="password_confirmation" class="form-control border-end-0" 
                                       name="password_confirmation" placeholder="Ulangi password" required style="border-radius: 8px 0 0 8px;">
                                <span class="input-group-text bg-light border-start-0 cursor-pointer"
                                    style="border-radius: 0 8px 8px 0;" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye text-muted" id="password_confirmation-toggle"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" style="color: #374151;" for="terms">
                                Setuju dengan <a href="{{ route('terms') }}" target="_blank" class="text-decoration-none">Syarat & Ketentuan</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3" id="registerBtn">
                        <i class="fas fa-rocket me-1"></i> <span>Daftar & Kirim OTP</span>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0" style="color: #64748b;">Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">Login</a>
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(inputId + '-toggle');
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}
</script>

<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
@endsection