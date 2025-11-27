<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\EmailVerification;
use App\Mail\OtpMail;
use App\Services\NotificationService;
use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Store user data in session temporarily
        $request->session()->put('temp_user_data', [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // Generate and send OTP
        $verification = EmailVerification::generateOtp($request->email);
        Mail::to($request->email)->send(new OtpMail($verification->otp, $request->name));
        
        return redirect()->route('verify.otp.form')
            ->with('email', $request->email)
            ->with('success', 'Kode OTP telah dikirim ke email Anda!');
    }
    
    public function showVerifyOtp()
    {
        if (!session('email')) {
            return redirect()->route('register')->with('error', 'Silakan daftar terlebih dahulu.');
        }
        return view('auth.verify-otp');
    }
    
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);
        
        $verification = EmailVerification::where('email', $request->email)
            ->where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$verification || !$verification->isValid($request->otp)) {
            return back()->with('error', 'Kode OTP tidak valid atau sudah kedaluwarsa.');
        }
        
        // Mark OTP as verified
        $verification->update(['is_verified' => true]);
        
        // Get temp user data from session
        $tempUserData = session('temp_user_data');
        if (!$tempUserData) {
            return redirect()->route('register')->with('error', 'Data registrasi tidak ditemukan. Silakan daftar ulang.');
        }
        
        // Create user account
        $role = Role::where('name', 'Calon Siswa')->first();
        $user = User::create([
            'name' => $tempUserData['name'],
            'username' => $tempUserData['username'],
            'email' => $tempUserData['email'],
            'password' => $tempUserData['password'],
            'role_id' => $role->id,
            'email_verified_at' => now(),
        ]);
        
        // Clear session data
        $request->session()->forget(['temp_user_data', 'email']);
        
        \Log::info('User verified successfully, redirecting to login', ['user_id' => $user->id, 'email' => $user->email]);
        
        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Akun Anda telah aktif. Silakan login.');
    }
    
    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $tempUserData = session('temp_user_data');
        if (!$tempUserData) {
            return redirect()->route('register')->with('error', 'Sesi registrasi telah berakhir. Silakan daftar ulang.');
        }
        
        // Generate new OTP
        $verification = EmailVerification::generateOtp($request->email);
        Mail::to($request->email)->send(new OtpMail($verification->otp, $tempUserData['name']));
        
        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->login;
        
        // Determine login field: email or username
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }
        
        $credentials = [
            $field => $login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Double check user exists and has valid role
            $user = Auth::user();
            if (!$user || !$user->role) {
                Auth::logout();
                return back()->withErrors(['login' => 'Invalid user account.']);
            }
            
            // Check if email is verified for new users
            if ($field === 'email' && !$user->email_verified_at) {
                Auth::logout();
                return back()->withErrors(['login' => 'Email belum diverifikasi. Silakan cek email Anda.']);
            }
            
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'login' => 'Username/Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        
        // Clear any cached user data
        if ($request->hasSession()) {
            $request->session()->forget('user');
        }
        
        $response = redirect('/')->with('success', 'Anda telah berhasil logout.');
        
        // Prevent browser caching
        return $response->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }
        
        // Generate OTP untuk reset password
        $verification = EmailVerification::generateOtp($request->email);
        Mail::to($request->email)->send(new OtpMail($verification->otp, $user->name));
        
        return redirect()->route('password.verify.form')
            ->with('email', $request->email)
            ->with('status', 'Kode OTP telah dikirim ke email Anda!');
    }
    
    public function showVerifyResetOtp()
    {
        if (!session('email')) {
            return redirect()->route('password.request')->with('error', 'Silakan masukkan email terlebih dahulu.');
        }
        return view('auth.verify-reset-otp');
    }
    
    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);
        
        $verification = EmailVerification::where('email', $request->email)
            ->where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$verification) {
            return back()->with('error', 'Kode OTP tidak ditemukan. Silakan minta OTP baru.');
        }
        
        if (!$verification->isValid($request->otp)) {
            return back()->with('error', 'Kode OTP tidak valid atau sudah kedaluwarsa.');
        }
        
        // Mark OTP as verified
        $verification->update(['is_verified' => true]);
        
        // Store verified email in session
        $request->session()->put('reset_email', $request->email);
        
        return redirect()->route('password.reset.form')
            ->with('success', 'OTP berhasil diverifikasi! Silakan masukkan password baru.');
    }
    
    public function resendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }
        
        // Generate new OTP
        $verification = EmailVerification::generateOtp($request->email);
        Mail::to($request->email)->send(new OtpMail($verification->otp, $user->name));
        
        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda!');
    }
    
    public function showResetPasswordForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request')->with('error', 'Sesi reset password tidak valid.');
        }
        return view('auth.reset-password-form');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        // Clear session
        $request->session()->forget('reset_email');
        
        return redirect()->route('login')->with('status', 'Password berhasil diperbarui! Silakan login dengan password baru.');
    }



    public function showCheckResetLink()
    {
        return view('auth.check-reset-link');
    }

    public function checkResetLink(Request $request)
    {
        $request->validate(['login' => 'required']);
        
        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';
        
        $user = User::where($field, $login)->first();
        
        if (!$user) {
            return back()->with('error', 'Email/NIK tidak ditemukan.');
        }
        
        // Cek apakah ada token reset yang masih valid
        $resetToken = \DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$resetToken) {
            return back()->with('error', 'Tidak ada link reset password yang aktif. Silakan buat link reset baru.');
        }
        
        $resetLink = url('/reset-password/' . $resetToken->token . '?email=' . urlencode($user->email));
        
        return view('auth.check-reset-link', compact('resetLink'));
    }
}