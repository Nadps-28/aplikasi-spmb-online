<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;

return new class extends Migration
{
    public function up()
    {
        // Update pendaftaran yang pembayarannya sudah verified tapi statusnya belum lulus
        $pendaftarans = Pendaftaran::whereHas('pembayaran', function($query) {
            $query->where('status', 'verified');
        })->where('status', '!=', 'lulus')->get();

        foreach ($pendaftarans as $pendaftaran) {
            $pendaftaran->update([
                'status' => 'lulus',
                'graduated_at' => $pendaftaran->payment_verified_at ?? now(),
                'graduated_by' => $pendaftaran->payment_verified_by ?? 1,
                'catatan_kelulusan' => 'Selamat! Anda telah diterima sebagai siswa baru. Selamat bergabung dengan keluarga besar sekolah kami!'
            ]);
        }

        // Update pembayaran yang statusnya masih menggunakan enum lama
        Pembayaran::where('status', 'terbayar')->update(['status' => 'verified']);
    }

    public function down()
    {
        // Rollback tidak diperlukan karena ini perbaikan data
    }
};