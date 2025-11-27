<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Pendaftaran extends Model
{
    use Auditable;
    protected $fillable = [
        'nomor_pendaftaran', 'user_id', 'jurusan_id', 'gelombang_id',
        'nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'agama', 'alamat', 'kecamatan', 'kelurahan', 'kodepos',
        'latitude', 'longitude', 'asal_sekolah',
        'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu',
        'nama_wali', 'pekerjaan_wali', 'phone_ortu',
        'status', 'catatan_verifikasi', 'catatan_kelulusan',
        'verified_at', 'verified_by', 'payment_verified_at', 'payment_verified_by',
        'graduated_at', 'graduated_by'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    // Status constants sesuai flow baru
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_VALID = 'valid';
    const STATUS_LUNAS = 'lunas';
    const STATUS_LULUS = 'lulus';
    const STATUS_REJECTED = 'rejected';
    const STATUS_TIDAK_VALID = 'tidak_valid';
    const STATUS_BELUM_BAYAR = 'belum_bayar';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_VALID => 'Valid',
            self::STATUS_LUNAS => 'Lunas',
            self::STATUS_LULUS => 'Lulus',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_TIDAK_VALID => 'Tidak Valid',
            self::STATUS_BELUM_BAYAR => 'Belum Bayar'
        ];
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_DRAFT => 'secondary',
            self::STATUS_SUBMITTED => 'warning',
            self::STATUS_VALID => 'info',
            self::STATUS_LUNAS => 'primary',
            self::STATUS_LULUS => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_TIDAK_VALID => 'danger',
            self::STATUS_BELUM_BAYAR => 'warning'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function canEdit()
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_SUBMITTED]);
    }

    public function isComplete()
    {
        return $this->status !== self::STATUS_DRAFT;
    }

    // Flow methods
    public function canBeVerified()
    {
        return $this->status === self::STATUS_SUBMITTED;
    }

    public function canPaymentBeVerified()
    {
        return $this->status === self::STATUS_VALID;
    }

    public function canBeGraduated()
    {
        return $this->status === self::STATUS_VALID;
    }
    
    public function isValidForManualGraduation()
    {
        return $this->status === self::STATUS_VALID && !$this->pembayaran;
    }
    
    public function hasValidDocuments()
    {
        $requiredDocs = ['ijazah', 'rapor', 'kk', 'akte', 'foto'];
        $uploadedDocs = $this->berkas->pluck('jenis_berkas')->toArray();
        
        foreach ($requiredDocs as $doc) {
            if (!in_array($doc, $uploadedDocs)) {
                return false;
            }
        }
        return true;
    }
    
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_DRAFT => 'Draft - Belum Lengkap',
            self::STATUS_SUBMITTED => 'Menunggu Verifikasi Admin',
            self::STATUS_VALID => 'Valid - Menunggu Pembayaran',
            self::STATUS_LUNAS => 'Pembayaran Lunas',
            self::STATUS_LULUS => 'Lulus - Diterima',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_TIDAK_VALID => 'Tidak Valid - Berkas Ditolak',
            self::STATUS_BELUM_BAYAR => 'Pembayaran Ditolak'
        ];
        
        return $labels[$this->status] ?? 'Status Tidak Dikenal';
    }
}