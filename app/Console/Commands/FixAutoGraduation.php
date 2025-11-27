<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;

class FixAutoGraduation extends Command
{
    protected $signature = 'spmb:fix-graduation';
    protected $description = 'Fix auto graduation for verified payments';

    public function handle()
    {
        $this->info('Memperbaiki auto graduation...');

        // Update pendaftaran yang pembayarannya sudah verified tapi belum lulus
        $pendaftarans = Pendaftaran::whereHas('pembayaran', function($query) {
            $query->where('status', 'verified');
        })->where('status', '!=', 'lulus')->get();

        $fixed = 0;
        foreach ($pendaftarans as $pendaftaran) {
            $pendaftaran->update([
                'status' => 'lulus',
                'graduated_at' => $pendaftaran->payment_verified_at ?? now(),
                'graduated_by' => $pendaftaran->payment_verified_by ?? 1,
                'catatan_kelulusan' => 'Selamat! Anda telah diterima sebagai siswa baru. Selamat bergabung dengan keluarga besar sekolah kami!'
            ]);
            $fixed++;
        }

        $this->info("Berhasil memperbaiki {$fixed} data pendaftaran");
        
        // Update status pembayaran lama
        $oldPayments = Pembayaran::where('status', 'terbayar')->count();
        if ($oldPayments > 0) {
            Pembayaran::where('status', 'terbayar')->update(['status' => 'verified']);
            $this->info("Berhasil update {$oldPayments} status pembayaran lama");
        }

        $this->info('Selesai!');
        return 0;
    }
}