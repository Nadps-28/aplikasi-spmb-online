@extends('layouts.app')

@section('title', 'Reset Password - SPMB')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 2rem 1rem;">
    <div class="w-100" style="max-width: 500px;">
        <div class="glass-card p-4">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #4ecdc4, #3dd5d0); border-radius: 15px;">
                    <i class="fas fa-lock fa-lg text-white"></i>
                </div>
                <h4 class="fw-bold mb-2">Reset Password</h4>
                <p class="text-muted mb-0">Masukkan password baru Anda</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: white !important;">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email', $request->email) }}" required readonly>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: white !important;">Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" placeholder="Masukkan password baru" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: white !important;">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation" 
                           placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3">
                    <i class="fas fa-save me-2"></i> Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection