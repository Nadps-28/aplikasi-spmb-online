@extends('layouts.app')

@section('title', 'Lupa Password - SPMB')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 2rem 1rem;">
    <div class="w-100" style="max-width: 500px;">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 20px; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                        <i class="fas fa-lock fa-2x text-white"></i>
                    </div>
                    <h3 class="fw-bold mb-2 text-dark">Reset Password</h3>
                    <p class="text-muted mb-0">Masukkan email Anda untuk menerima kode OTP</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success border-0 rounded-3 mb-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Email</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-0 bg-light @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Kode OTP
                    </button>
                </form>

                <div class="text-center mt-4">
                    <div class="d-flex align-items-center my-4">
                        <hr class="flex-grow-1">
                        <span class="px-3 text-muted small">atau</span>
                        <hr class="flex-grow-1">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('password.verify.form') }}" class="btn btn-outline-success rounded-3">
                            <i class="fas fa-key me-2"></i> Sudah Punya Kode OTP?
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-3">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection