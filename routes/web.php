<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\VerifikatorController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\ExportKeuanganController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\AuditLogController;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Validate user and role exist
        if (!$user || !$user->role) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            $jurusans = \App\Models\Jurusan::where('aktif', true)->get();
            return view('welcome', compact('jurusans'));
        }
        return redirect()->route('dashboard');
    }
    $jurusans = \App\Models\Jurusan::where('aktif', true)->get();
    return view('welcome', compact('jurusans'));
})->name('home');

// Terms & Conditions (accessible to all users)
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Password Reset Guide
Route::get('/panduan-reset-password', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('panduan-reset-password');
})->name('password.guide');

// Password Reset Routes (accessible to all)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/verify-reset-otp', [AuthController::class, 'showVerifyResetOtp'])->name('password.verify.form');
Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp'])->name('password.verify');
Route::post('/resend-reset-otp', [AuthController::class, 'resendResetOtp'])->name('password.resend');
Route::get('/reset-password-form', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('password.update');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp.form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Calon Siswa Routes
    Route::middleware('role:Calon Siswa')->group(function () {
        Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
        Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::get('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::get('/pendaftaran/{pendaftaran}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
        Route::put('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
        Route::post('/pendaftaran/{pendaftaran}/submit', [PendaftaranController::class, 'submit'])->name('pendaftaran.submit');
        
        // Berkas Routes
        Route::get('/pendaftaran/{pendaftaran}/berkas', [BerkasController::class, 'index'])->name('berkas.index');
        Route::post('/pendaftaran/{pendaftaran}/berkas', [BerkasController::class, 'store'])->name('berkas.store');
        Route::delete('/berkas/{berkas}', [BerkasController::class, 'destroy'])->name('berkas.destroy');
        
        // Pembayaran Routes
        Route::get('/pendaftaran/{pendaftaran}/pembayaran', [PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::post('/pendaftaran/{pendaftaran}/pembayaran/upload', [PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload');
        

    });
    
    // Pembayaran Verifikasi (accessible by multiple roles)
    Route::middleware('role:Keuangan,Admin Panitia')->group(function () {
        Route::post('/pembayaran/{pembayaran}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
    });
    
    // Admin Routes
    Route::middleware('role:Admin Panitia')->group(function () {
        Route::get('/admin/master-data', [\App\Http\Controllers\AdminController::class, 'masterData'])->name('admin.master-data');
        Route::get('/admin/monitoring', [\App\Http\Controllers\AdminController::class, 'monitoring'])->name('admin.monitoring');
        Route::get('/admin/peta-sebaran', [\App\Http\Controllers\AdminController::class, 'petaSebaran'])->name('admin.peta-sebaran');
        Route::post('/admin/jurusan', [\App\Http\Controllers\AdminController::class, 'storeJurusan'])->name('admin.jurusan.store');
        Route::post('/admin/gelombang', [\App\Http\Controllers\AdminController::class, 'storeGelombang'])->name('admin.gelombang.store');
        Route::post('/admin/gelombang/{id}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleGelombang'])->name('admin.gelombang.toggle');
        
        // Graduation Routes - Flow baru: lunas -> lulus
        Route::post('/admin/graduate/{id}', [\App\Http\Controllers\AdminController::class, 'graduateStudent'])->name('admin.graduate');
        Route::post('/admin/auto-graduate', [\App\Http\Controllers\AdminController::class, 'autoGraduateAll'])->name('admin.auto-graduate');
        
        // Audit Log Routes
        Route::get('/admin/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');
        Route::get('/admin/notification-logs', [AuditLogController::class, 'notifications'])->name('admin.notification-logs');
    });
    
    // Export Routes
    Route::middleware('role:Admin Panitia,Kepala Sekolah')->group(function () {
        Route::get('/export/pendaftar', [\App\Http\Controllers\ExportController::class, 'exportPendaftar'])->name('export.pendaftar');
    });
    
    // Verifikator Routes
    Route::middleware('role:Verifikator Administrasi')->group(function () {
        Route::get('/verifikator', [\App\Http\Controllers\VerifikatorController::class, 'index'])->name('verifikator.index');
        Route::get('/verifikator/{pendaftaran}', [\App\Http\Controllers\VerifikatorController::class, 'show'])->name('verifikator.show');
        Route::post('/verifikator/{pendaftaran}/verifikasi', [\App\Http\Controllers\VerifikatorController::class, 'verifikasi'])->name('verifikator.verifikasi');
        Route::post('/verifikator/{pendaftaran}/tolak', [\App\Http\Controllers\VerifikatorController::class, 'tolak'])->name('verifikator.tolak');
    });
    
    // Keuangan Routes
    Route::middleware('role:Keuangan')->group(function () {
        Route::get('/dashboard/keuangan', [\App\Http\Controllers\KeuanganController::class, 'dashboard'])->name('dashboard.keuangan');
        Route::post('/keuangan/verifikasi/{id}', [\App\Http\Controllers\KeuanganController::class, 'verifikasiPembayaran'])->name('keuangan.verifikasi.ajax');
        Route::get('/keuangan/{pembayaran}', [\App\Http\Controllers\KeuanganController::class, 'show'])->name('keuangan.show');
        Route::post('/keuangan/{pembayaran}/verifikasi', [\App\Http\Controllers\KeuanganController::class, 'verifikasi'])->name('keuangan.verifikasi');
        Route::get('/keuangan/laporan', function() { return redirect()->route('dashboard.keuangan'); })->name('keuangan.laporan');
        Route::get('/export/keuangan', [\App\Http\Controllers\ExportKeuanganController::class, 'exportPembayaran'])->name('export.keuangan');
        Route::get('/export/keuangan/pdf', [\App\Http\Controllers\ExportKeuanganController::class, 'exportPDF'])->name('export.keuangan.pdf');
        Route::get('/export/keuangan/excel', function() { return redirect()->route('export.keuangan', ['format' => 'excel']); })->name('export.keuangan.excel');
        Route::get('/export/keuangan/csv', function() { return redirect()->route('export.keuangan', ['format' => 'csv']); })->name('export.keuangan.csv');
    });
    
    // Kepala Sekolah Routes
    Route::middleware('role:Kepala Sekolah')->group(function () {
        Route::get('/kepala-sekolah/analytics', [\App\Http\Controllers\KepalaSekolahController::class, 'analytics'])->name('kepala-sekolah.analytics');
        Route::get('/kepala-sekolah/laporan', [\App\Http\Controllers\KepalaSekolahController::class, 'laporan'])->name('kepala-sekolah.laporan');
        Route::get('/kepala-sekolah/laporan/excel', [\App\Http\Controllers\KepalaSekolahController::class, 'exportLaporanExcel'])->name('kepala-sekolah.laporan.excel');
        Route::get('/kepala-sekolah/laporan/pdf', [\App\Http\Controllers\KepalaSekolahController::class, 'exportLaporanPdf'])->name('kepala-sekolah.laporan.pdf');
        Route::get('/kepala-sekolah/kelulusan', [\App\Http\Controllers\KepalaSekolahController::class, 'kelulusan'])->name('kepala-sekolah.kelulusan');
        Route::get('/kepala-sekolah/kelulusan/{pendaftaran}/detail', [\App\Http\Controllers\KepalaSekolahController::class, 'detailSiswa'])->name('kepala-sekolah.detail-siswa');
        Route::get('/kepala-sekolah/kelulusan/export', [\App\Http\Controllers\KepalaSekolahController::class, 'exportKelulusan'])->name('kepala-sekolah.export-kelulusan');
    });
    
    // Dashboard API Routes
    Route::middleware('role:Admin Panitia,Kepala Sekolah')->group(function () {
        Route::get('/dashboard/tren-data', [DashboardController::class, 'getTrenData'])->name('dashboard.tren-data');
        Route::get('/dashboard/kpi-data', [DashboardController::class, 'getKpiData'])->name('dashboard.kpi-data');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
    });
});
