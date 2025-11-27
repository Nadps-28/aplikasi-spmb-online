<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'is_verified'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    public function isExpired()
    {
        return $this->expires_at < now();
    }

    public function isValid($otp)
    {
        \Log::info('Validating OTP', [
            'provided_otp' => $otp,
            'stored_otp' => $this->otp,
            'is_expired' => $this->isExpired(),
            'is_verified' => $this->is_verified,
            'expires_at' => $this->expires_at
        ]);
        
        return $this->otp === $otp && !$this->isExpired() && !$this->is_verified;
    }

    public static function generateOtp($email)
    {
        // Delete old OTPs for this email
        self::where('email', $email)->delete();
        
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        return self::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5)
        ]);
    }
}
