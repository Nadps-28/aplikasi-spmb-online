@extends('layouts.app')

@section('title', 'Verifikasi Email - SPMB')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 2rem 1rem; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); position: relative;">
    <div class="position-absolute w-100 h-100" style="background-image: radial-gradient(circle at 20% 80%, rgba(37, 99, 235, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(5, 150, 105, 0.1) 0%, transparent 50%); opacity: 0.8;"></div>
    <div class="w-100 position-relative" style="max-width: 500px; z-index: 1;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px;">
                        <i class="fas fa-envelope-open fa-2x text-white"></i>
                    </div>
                    <h4 class="fw-bold mb-2" style="color: #1e293b;">Verifikasi Email</h4>
                    <p class="mb-0" style="color: #64748b;">Masukkan kode OTP yang dikirim ke email Anda</p>
                    <div class="d-flex justify-content-center mt-3 gap-2">
                        <span class="badge bg-success">1. Isi Data ✓</span>
                        <span class="badge bg-primary">2. Verifikasi Email</span>
                        <span class="badge bg-light text-dark">3. Selesai</span>
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="text-center mb-4">
                    <div class="bg-light rounded-3 p-3 mb-3">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <strong>{{ session('email') }}</strong>
                    </div>
                    <p class="small text-muted">Kode OTP berlaku selama 5 menit</p>
                </div>

                <form method="POST" action="{{ route('verify.otp') }}" id="otpForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-center d-block" style="color: #374151;">Kode OTP (6 Digit)</label>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <input type="text" class="form-control text-center fw-bold otp-input" maxlength="1" style="width: 50px; height: 60px; font-size: 24px; border-radius: 12px;" data-index="0">
                            <input type="text" class="form-control text-center fw-bold otp-input" maxlength="1" style="width: 50px; height: 60px; font-size: 24px; border-radius: 12px;" data-index="1">
                            <input type="text" class="form-control text-center fw-bold otp-input" maxlength="1" style="width: 50px; height: 60px; font-size: 24px; border-radius: 12px;" data-index="2">
                            <input type="text" class="form-control text-center fw-bold otp-input" maxlength="1" style="width: 50px; height: 60px; font-size: 24px; border-radius: 12px;" data-index="3">
                            <input type="text" class="form-control text-center fw-bold otp-input" maxlength="1" style="width: 50px; height: 60px; font-size: 24px; border-radius: 12px;" data-index="4">
                            <input type="text" class="form-control text-center fw-bold otp-input" maxlength="1" style="width: 50px; height: 60px; font-size: 24px; border-radius: 12px;" data-index="5">
                        </div>
                        <input type="hidden" name="otp" id="otpValue">
                        @error('otp')
                            <div class="text-danger small text-center">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-3" id="verifyBtn">
                        <i class="fas fa-check me-1"></i> Verifikasi Email
                    </button>
                </form>

                <div class="text-center">
                    <p class="mb-2" style="color: #64748b;">Tidak menerima kode?</p>
                    <form method="POST" action="{{ route('resend.otp') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        <button type="submit" class="btn btn-link text-decoration-none fw-semibold p-0" id="resendBtn">
                            Kirim Ulang OTP
                        </button>
                    </form>
                    <div id="countdown" class="small text-muted mt-2" style="display: none;">
                        Kirim ulang dalam <span id="timer">60</span> detik
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const otpValue = document.getElementById('otpValue');
    const resendBtn = document.getElementById('resendBtn');
    const countdown = document.getElementById('countdown');
    const timer = document.getElementById('timer');
    
    // OTP Input handling
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            if (e.target.value.length === 1) {
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            }
            updateOtpValue();
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
        
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').slice(0, 6);
            pastedData.split('').forEach((char, i) => {
                if (i < otpInputs.length) {
                    otpInputs[i].value = char;
                }
            });
            updateOtpValue();
        });
    });
    
    function updateOtpValue() {
        const otp = Array.from(otpInputs).map(input => input.value).join('');
        otpValue.value = otp;
    }
    
    // Countdown timer for resend
    let countdownTime = 60;
    function startCountdown() {
        resendBtn.style.display = 'none';
        countdown.style.display = 'block';
        
        const interval = setInterval(() => {
            countdownTime--;
            timer.textContent = countdownTime;
            
            if (countdownTime <= 0) {
                clearInterval(interval);
                resendBtn.style.display = 'inline';
                countdown.style.display = 'none';
                countdownTime = 60;
            }
        }, 1000);
    }
    
    // Start countdown on page load
    startCountdown();
    
    // Restart countdown when resend is clicked
    resendBtn.addEventListener('click', function() {
        startCountdown();
    });
});
</script>
@endsection