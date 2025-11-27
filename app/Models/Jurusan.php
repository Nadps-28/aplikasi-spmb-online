<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = ['nama', 'biaya_daftar', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
        'biaya_daftar' => 'decimal:2',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
    

}