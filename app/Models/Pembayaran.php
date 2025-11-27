<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['pendaftaran_id', 'nominal', 'bukti_bayar', 'status', 'catatan', 'tanggal_bayar'];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}