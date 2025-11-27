@extends('layouts.app')

@section('title', 'Reset Password - SPMB')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 2rem 1rem;">
    <div class="w-100" style="max-width: 500px;">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 20px; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-key fa-2x text-white"></i>
                    </div>
                    <h3 class="fw-bold mb-2 text-dark">Password Baru</h3>
                    <p class="text-muted mb-0">Masukkan password baru untuk akun Anda</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-0 bg-light @error('password') is-invalid @enderror" 
                                   name="password" placeholder="Masukkan password baru" required>
                            <button type="button" class="btn btn-outline-secondary border-0 bg-light" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-0 bg-light @error('password_confirmation') is-invalid @enderror" 
                                   name="password_confirmation" placeholder="Konfirmasi password baru" required>
                            <button type="button" class="btn btn-outline-secondary border-0 bg-light" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger small mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info border-0 rounded-3 mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Password minimal 8 karakter, kombinasi huruf dan angka</small>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 py-3 fw-semibold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: white;">
                        <i class="fas fa-save me-2"></i> Update Password
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-3">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldName) {
    const field = document.querySelector(`input[name="${fieldName}"]`);
    const eye = document.getElementById(`${fieldName}-eye`);
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>
@endsection