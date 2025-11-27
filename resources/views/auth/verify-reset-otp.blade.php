@extends('layouts.app')

@section('title', 'Verifikasi OTP Reset Password - SPMB')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 2rem 1rem;">
    <div class="w-100" style="max-width: 500px;">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 20px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-shield-alt fa-2x text-white"></i>
                    </div>
                    <h3 class="fw-bold mb-2 text-dark">Verifikasi OTP</h3>
                    <p class="text-muted mb-0">Masukkan kode OTP yang telah dikirim ke email Anda</p>
                    @if(session('email'))
                        <small class="text-primary fw-semibold">{{ session('email') }}</small>
                    @endif
                </div>

                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 mb-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.verify') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Kode OTP</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light">
                                <i class="fas fa-key text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light @error('otp') is-invalid @enderror" 
                                   name="otp" placeholder="Masukkan 6 digit kode OTP" maxlength="6" required>
                        </div>
                        @error('otp')
                            <div class="text-danger small mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-3 fw-semibold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                        <i class="fas fa-check me-2"></i> Verifikasi OTP
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted mb-3">Tidak menerima kode OTP?</p>
                    <form method="POST" action="{{ route('password.resend') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        <button type="submit" class="btn btn-outline-warning rounded-3">
                            <i class="fas fa-redo me-2"></i> Kirim Ulang OTP
                        </button>
                    </form>
                    
                    <div class="mt-3">
                        <a href="{{ route('password.request') }}" class="btn btn-outline-secondary rounded-3">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection