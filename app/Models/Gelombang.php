<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    protected $fillable = ['nama', 'tanggal_mulai', 'tanggal_selesai', 'aktif'];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'aktif' => 'boolean',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // Method untuk mengecek apakah gelombang sedang aktif
    public function isActive()
    {
        $now = now()->toDateString();
        return $this->aktif && 
               $this->tanggal_mulai <= $now && 
               $this->tanggal_selesai >= $now;
    }

    // Method untuk mengecek apakah gelombang belum dimulai
    public function isUpcoming()
    {
        return $this->aktif && $this->tanggal_mulai > now()->toDateString();
    }

    // Method untuk mengecek apakah gelombang sudah selesai
    public function isExpired()
    {
        return $this->tanggal_selesai < now()->toDateString();
    }

    // Method untuk mendapatkan status gelombang
    public function getStatusAttribute()
    {
        if (!$this->aktif) {
            return 'nonaktif';
        }
        
        if ($this->isUpcoming()) {
            return 'belum_dimulai';
        }
        
        if ($this->isExpired()) {
            return 'selesai';
        }
        
        if ($this->isActive()) {
            return 'aktif';
        }
        
        return 'nonaktif';
    }

    // Scope untuk gelombang yang bisa dipilih (aktif dan dalam periode)
    public function scopeAvailable($query)
    {
        $now = now()->toDateString();
        return $query->where('aktif', true)
                    ->where('tanggal_mulai', '<=', $now)
                    ->where('tanggal_selesai', '>=', $now);
    }
}