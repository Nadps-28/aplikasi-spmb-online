@extends('layouts.app')

@section('title', 'Cek Link Reset Password - SPMB')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 2rem 1rem;">
    <div class="w-100" style="max-width: 600px;">
        <div class="glass-card p-4">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #4ecdc4, #3dd5d0); border-radius: 15px;">
                    <i class="fas fa-search fa-lg text-white"></i>
                </div>
                <h4 class="fw-bold mb-2">Cek Link Reset Password</h4>
                <p class="text-muted mb-0">Masukkan email atau NIK untuk melihat link reset password Anda</p>
            </div>

            <form method="POST" action="{{ route('password.check') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: white !important;">Email atau NIK</label>
                    <input type="text" class="form-control @error('login') is-invalid @enderror" 
                           name="login" value="{{ old('login') }}" placeholder="Masukkan email atau NIK Anda" required>
                    @error('login')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3">
                    <i class="fas fa-search me-2"></i> Cek Link Reset
                </button>
            </form>

            @if(isset($resetLink))
                <div class="alert alert-success mt-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-link me-2"></i> Link Reset Password Anda:</h6>
                    <div class="bg-dark p-3 rounded mb-3">
                        <small class="text-white" style="word-break: break-all;">{{ $resetLink }}</small>
                    </div>
                    <a href="{{ $resetLink }}" class="btn btn-success btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i> Buka Link Reset
                    </a>
                    <p class="small text-muted mt-2 mb-0">
                        <i class="fas fa-clock me-1"></i> Link ini berlaku selama 60 menit
                    </p>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="text-center mt-4">
                <p class="text-muted mb-0">Belum punya link reset? 
                    <a href="{{ route('password.request') }}" class="text-decoration-none fw-semibold text-primary">Buat link reset</a>
                </p>
                <p class="text-muted mb-0 mt-2">Kembali ke 
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection