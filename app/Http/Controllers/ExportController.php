<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportPendaftar()
    {
        try {
            $pendaftarans = Pendaftaran::with(['user', 'jurusan', 'gelombang'])->get();
            
            $filename = 'data_pendaftar_' . date('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            $callback = function() use ($pendaftarans) {
                $file = fopen('php://output', 'w');
                
                fputcsv($file, [
                    'No Pendaftaran', 'Nama', 'Email', 'NIK', 'Jurusan', 
                    'Gelombang', 'Status', 'Tanggal Daftar'
                ]);
                
                foreach ($pendaftarans as $pendaftaran) {
                    fputcsv($file, [
                        $pendaftaran->nomor_pendaftaran ?? '',
                        $pendaftaran->nama_lengkap ?? '',
                        $pendaftaran->user->email ?? '',
                        $pendaftaran->nik ?? '',
                        $pendaftaran->jurusan->nama ?? '',
                        $pendaftaran->gelombang->nama ?? '',
                        $pendaftaran->status ?? '',
                        $pendaftaran->created_at ? $pendaftaran->created_at->format('d/m/Y') : '',
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
}