@extends('layouts.app')

@section('title', 'Login - SPMB')

@section('content')
    <div class="d-flex align-items-center justify-content-center"
        style="min-height: 100vh; padding: 2rem 1rem; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); position: relative;">
        <div class="position-absolute w-100 h-100"
            style="background-image: radial-gradient(circle at 20% 80%, rgba(37, 99, 235, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(5, 150, 105, 0.1) 0%, transparent 50%), radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.05) 0%, transparent 50%); opacity: 0.8;">
        </div>
        <div class="w-100 position-relative" style="max-width: 900px; z-index: 1;">
            <div class="row g-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <!-- Left Side - Branding -->
                <div class="col-md-6 d-none d-md-block position-relative">
                    <div class="h-100 d-flex align-items-center justify-content-center position-relative"
                        style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); overflow: hidden; min-height: 450px;">
                        <div class="text-center text-white p-3 position-relative">
                            <div class="mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center mb-3 position-relative"
                                    style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.2); border-radius: 20px;">
                                    <i class="fas fa-graduation-cap fa-2x" style="color: white;"></i>
                                </div>
                                <h3 class="fw-bold mb-2">SMK Bakti Nusantara 666</h3>
                                <p class="mb-3">Sistem Penerimaan Murid Baru Online</p>
                            </div>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="bg-white bg-opacity-20 rounded-3 p-2 mb-2">
                                        <i class="fas fa-bolt fa-lg" style="color: #fbbf24;"></i>
                                    </div>
                                    <small>Cepat & Mudah</small>
                                </div>
                                <div class="col-4">
                                    <div class="bg-white bg-opacity-20 rounded-3 p-2 mb-2">
                                        <i class="fas fa-shield-alt fa-lg" style="color: #10b981;"></i>
                                    </div>
                                    <small>Aman & Terpercaya</small>
                                </div>
                                <div class="col-4">
                                    <div class="bg-white bg-opacity-20 rounded-3 p-2 mb-2">
                                        <i class="fas fa-headset fa-lg" style="color: #f87171;"></i>
                                    </div>
                                    <small>Support 24/7</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="col-md-6">
                    <div class="p-4 h-100 d-flex align-items-center" style="background: white; min-height: 450px;">
                        <div class="w-100">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center mb-3 position-relative"
                                    style="width: 70px; height: 70px; background-color: #2563eb; border-radius: 20px;">
                                    <i class="fas fa-rocket fa-2x text-white"></i>
                                </div>
                                <h4 class="fw-bold mb-2" style="color: #1e293b;">Selamat Datang Kembali</h4>
                                <p class="mb-0" style="color: #64748b;">Masuk ke dashboard SPMB Anda</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="color: #374151;">Username atau
                                        Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"
                                            style="border-radius: 8px 0 0 8px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control border-start-0 @error('login') is-invalid @enderror"
                                            name="login" value="{{ old('login') }}" placeholder="Username atau Email"
                                            required style="border-radius: 0 8px 8px 0;">
                                    </div>
                                    <small class="text-muted">Gunakan username atau email untuk login</small>
                                    @error('login')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="color: #374151;">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"
                                            style="border-radius: 8px 0 0 8px;">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" id="password"
                                            class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                            name="password" placeholder="Masukkan password Anda" required
                                            style="border-radius: 0;">
                                        <span class="input-group-text bg-light border-start-0 cursor-pointer"
                                            style="border-radius: 0 8px 8px 0;" onclick="togglePassword('password')">
                                            <i class="fas fa-eye text-muted" id="password-toggle"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" style="color: #374151;" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}"
                                        class="text-decoration-none fw-semibold text-primary">Lupa password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 shadow-sm">
                                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Dashboard
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <p class="mb-2" style="color: #64748b;">Belum punya akun?
                                    <a href="{{ route('register') }}"
                                        class="text-decoration-none fw-semibold text-primary">Daftar sekarang</a>
                                </p>
                                <p class="mb-0 small" style="color: #64748b;">Butuh bantuan reset password?
                                    <a href="{{ route('password.guide') }}"
                                        class="text-decoration-none fw-semibold text-success">Lihat panduan</a>
                                </p>
                            </div>
                        </div>
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