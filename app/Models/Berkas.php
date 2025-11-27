<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $fillable = ['pendaftaran_id', 'jenis', 'nama_file', 'path_file', 'status', 'catatan'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}