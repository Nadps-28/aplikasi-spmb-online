<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KepalaSekolahController extends Controller
{
    public function kelulusan()
    {
        // Pendaftar per Jurusan (tanpa kuota untuk sekolah swasta)
        $jurusans = \App\Models\Jurusan::where('aktif', true)
            ->withCount('pendaftarans')
            ->get()
            ->map(function($jurusan) {
                return [
                    'nama' => $jurusan->nama,
                    'pendaftar' => $jurusan->pendaftarans_count
                ];
            });

        // Tren Harian 30 hari terakhir
        $trenHarian = \App\Models\Pendaftaran::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Komposisi Asal Sekolah
        $asalSekolah = \App\Models\Pendaftaran::selectRaw('asal_sekolah, COUNT(*) as total')
            ->whereNotNull('asal_sekolah')
            ->groupBy('asal_sekolah')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Komposisi Asal Wilayah
        $asalWilayah = \App\Models\Pendaftaran::selectRaw('kecamatan, COUNT(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // KPI Utama dengan rasio terverifikasi
        $totalPendaftar = \App\Models\Pendaftaran::count();
        $terverifikasi = \App\Models\Pendaftaran::whereIn('status', ['valid', 'lulus'])->count();
        
        $kpi = [
            'total_pendaftar' => $totalPendaftar,
            'lulus' => \App\Models\Pendaftaran::where('status', 'lulus')->count(),
            'pemasukan' => \App\Models\Pembayaran::where('status', 'verified')->sum('nominal'),
            'rasio_terverifikasi' => $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0
        ];

        return view('kepala-sekolah.kelulusan', compact('jurusans', 'trenHarian', 'asalWilayah', 'asalSekolah', 'kpi'));
    }
    
    // Method luluskan dan batchKelulusan dihapus karena sistem otomatis meluluskan siswa
    // setelah verifikasi pembayaran untuk sekolah swasta
    
    public function detailSiswa(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['user', 'jurusan', 'berkas', 'pembayaran']);
        return view('kepala-sekolah.detail-siswa', compact('pendaftaran'));
    }
    
    public function exportKelulusan()
    {
        $totalPendaftar = Pendaftaran::count();
        $terverifikasi = Pendaftaran::whereIn('status', ['valid', 'lulus'])->count();
        
        $data = [
            'pendaftarans' => Pendaftaran::with(['user', 'jurusan'])->get(),
            'kpi' => [
                'total_pendaftar' => $totalPendaftar,
                'lulus' => Pendaftaran::where('status', 'lulus')->count(),
                'rasio_verifikasi' => $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0,
                'pemasukan' => \App\Models\Pembayaran::where('status', 'verified')->sum('nominal')
            ],
            'jurusans' => \App\Models\Jurusan::where('aktif', true)->withCount('pendaftarans')->get(),
            'asal_sekolah' => \App\Models\Pendaftaran::selectRaw('asal_sekolah, COUNT(*) as total')
                ->whereNotNull('asal_sekolah')
                ->groupBy('asal_sekolah')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get(),
            'asal_wilayah' => \App\Models\Pendaftaran::selectRaw('kecamatan, COUNT(*) as total')
                ->whereNotNull('kecamatan')
                ->groupBy('kecamatan')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get(),
            'tanggal_export' => now()->format('d F Y H:i:s')
        ];
        
        return view('exports.laporan-kepsek', $data);
    }
    
    public function analytics()
    {
        $jurusans = \App\Models\Jurusan::where('aktif', true)
            ->withCount('pendaftarans')
            ->get()
            ->map(function($jurusan) {
                return [
                    'nama' => $jurusan->nama,
                    'pendaftar' => $jurusan->pendaftarans_count
                ];
            });

        // Generate 30 hari terakhir dengan data 0 jika tidak ada pendaftar
        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }
        
        $pendaftaranData = \App\Models\Pendaftaran::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');
            
        $trenHarian = $dates->map(function($date) use ($pendaftaranData) {
            return (object) [
                'tanggal' => $date,
                'total' => $pendaftaranData->get($date, 0)
            ];
        });

        $asalSekolah = \App\Models\Pendaftaran::selectRaw('asal_sekolah, COUNT(*) as total')
            ->whereNotNull('asal_sekolah')
            ->groupBy('asal_sekolah')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $asalWilayah = \App\Models\Pendaftaran::selectRaw('kecamatan, COUNT(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $totalPendaftar = \App\Models\Pendaftaran::count();
        $terverifikasi = \App\Models\Pendaftaran::whereIn('status', ['valid', 'lulus'])->count();
        
        $kpi = [
            'total_pendaftar' => $totalPendaftar,
            'lulus' => \App\Models\Pendaftaran::where('status', 'lulus')->count(),
            'pemasukan' => \App\Models\Pembayaran::where('status', 'verified')->sum('nominal'),
            'rasio_terverifikasi' => $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0
        ];

        return view('kepala-sekolah.analytics', compact('jurusans', 'trenHarian', 'asalWilayah', 'asalSekolah', 'kpi'));
    }
    
    public function laporan()
    {
        $jurusans = \App\Models\Jurusan::where('aktif', true)
            ->withCount('pendaftarans')
            ->get()
            ->map(function($jurusan) {
                $lulus = \App\Models\Pendaftaran::where('jurusan_id', $jurusan->id)
                    ->where('status', 'lulus')
                    ->count();
                    
                $pemasukan = \App\Models\Pembayaran::whereHas('pendaftaran', function($q) use ($jurusan) {
                    $q->where('jurusan_id', $jurusan->id);
                })->where('status', 'verified')->sum('nominal');
                
                return [
                    'nama' => $jurusan->nama,
                    'pendaftar' => $jurusan->pendaftarans_count,
                    'lulus' => $lulus,
                    'pemasukan' => $pemasukan
                ];
            });

        $asalSekolah = \App\Models\Pendaftaran::selectRaw('asal_sekolah, COUNT(*) as total')
            ->whereNotNull('asal_sekolah')
            ->groupBy('asal_sekolah')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $asalWilayah = \App\Models\Pendaftaran::selectRaw('kecamatan, COUNT(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $totalPendaftar = \App\Models\Pendaftaran::count();
        $terverifikasi = \App\Models\Pendaftaran::whereIn('status', ['valid', 'lulus'])->count();
        
        $kpi = [
            'total_pendaftar' => $totalPendaftar,
            'lulus' => \App\Models\Pendaftaran::where('status', 'lulus')->count(),
            'pemasukan' => \App\Models\Pembayaran::where('status', 'verified')->sum('nominal'),
            'rasio_terverifikasi' => $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0
        ];

        return view('kepala-sekolah.laporan', compact('jurusans', 'asalWilayah', 'asalSekolah', 'kpi'));
    }
    
    public function exportLaporanExcel()
    {
        $data = $this->getLaporanData();
        
        $html = view('exports.laporan-kepsek', $data)->render();
        
        $filename = 'laporan-kepala-sekolah-' . now()->format('Y-m-d-H-i-s') . '.html';
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    
    public function exportLaporanPdf()
    {
        $data = $this->getLaporanData();
        
        $pdf = \PDF::loadView('exports.laporan-kepsek', $data);
        
        return $pdf->download('laporan-kepala-sekolah-' . now()->format('Y-m-d-H-i-s') . '.pdf');
    }
    
    private function getLaporanData()
    {
        $totalPendaftar = Pendaftaran::count();
        $terverifikasi = Pendaftaran::whereIn('status', ['valid', 'lulus'])->count();
        
        return [
            'pendaftarans' => Pendaftaran::with(['user', 'jurusan'])->get(),
            'kpi' => [
                'total_pendaftar' => $totalPendaftar,
                'lulus' => Pendaftaran::where('status', 'lulus')->count(),
                'rasio_verifikasi' => $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0,
                'pemasukan' => \App\Models\Pembayaran::where('status', 'verified')->sum('nominal')
            ],
            'jurusans' => \App\Models\Jurusan::where('aktif', true)->withCount('pendaftarans')->get(),
            'asal_sekolah' => \App\Models\Pendaftaran::selectRaw('asal_sekolah, COUNT(*) as total')
                ->whereNotNull('asal_sekolah')
                ->groupBy('asal_sekolah')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get(),
            'asal_wilayah' => \App\Models\Pendaftaran::selectRaw('kecamatan, COUNT(*) as total')
                ->whereNotNull('kecamatan')
                ->groupBy('kecamatan')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get(),
            'tanggal_export' => now()->format('d F Y H:i:s')
        ];
    }
}