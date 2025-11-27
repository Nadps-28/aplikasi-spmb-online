<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        // Double check authentication
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Ensure user has a role
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => 'User role not found.']);
        }
        
        switch ($user->role->name) {
            case 'Calon Siswa':
                return $this->dashboardCalonSiswa();
            case 'Admin Panitia':
                return $this->dashboardAdmin();
            case 'Verifikator Administrasi':
                return $this->dashboardVerifikator();
            case 'Keuangan':
                return $this->dashboardKeuangan();
            case 'Kepala Sekolah':
                return $this->dashboardKepalaSekolah();
            default:
                return view('dashboard.default');
        }
    }

    private function dashboardCalonSiswa()
    {
        $pendaftaran = Auth::user()->pendaftaran;
        if ($pendaftaran) {
            $pendaftaran->load(['pembayaran', 'jurusan', 'gelombang']);
        }
        return view('dashboard.calon-siswa', compact('pendaftaran'));
    }

    private function dashboardAdmin()
    {
        try {
            // Validasi dan hitung statistik dengan penanganan error
            $totalPendaftar = Pendaftaran::count();
            $terverifikasi = Pendaftaran::where('status', 'valid')->count();
            $terbayar = Pendaftaran::whereHas('pembayaran', function($q) {
                $q->where('status', 'verified');
            })->count();
            $lulus = Pendaftaran::where('status', 'lulus')->count();
            
            // Validasi data untuk memastikan konsistensi
            $stats = [
                'total_pendaftar' => max(0, $totalPendaftar),
                'terverifikasi' => max(0, min($terverifikasi, $totalPendaftar)),
                'terbayar' => max(0, min($terbayar, $totalPendaftar)),
                'lulus' => max(0, min($lulus, $totalPendaftar)),
            ];
            
            // Data untuk grafik per jurusan
            $jurusanData = Jurusan::where('aktif', true)->withCount('pendaftarans')->get();
            $chartData = [
                'jurusan_labels' => $jurusanData->pluck('nama')->toArray(),
                'jurusan_data' => $jurusanData->pluck('pendaftarans_count')->toArray(),
            ];
            
            // Data pemasukan untuk grafik (gunakan status yang benar)
            $pemasukanData = \App\Models\Pembayaran::where('status', 'verified')
                ->selectRaw('DATE(updated_at) as tanggal, SUM(nominal) as total')
                ->where('updated_at', '>=', now()->subDays(7))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
                
            $chartData['pemasukan_labels'] = $pemasukanData->pluck('tanggal')->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('d/m');
            })->toArray();
            $chartData['pemasukan_data'] = $pemasukanData->pluck('total')->toArray();
            
            // Aktivitas terbaru dengan data real
            $aktivitasTerbaru = Pendaftaran::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            $aktivitas = [];
            foreach ($aktivitasTerbaru as $pendaftaran) {
                if (!$pendaftaran->user) continue; // Skip jika user tidak ada
                
                $waktu = $pendaftaran->created_at->diffForHumans();
                switch ($pendaftaran->status) {
                    case 'submitted':
                        $aktivitas[] = [
                            'icon' => 'user-plus',
                            'text' => 'Pendaftar baru: ' . $pendaftaran->user->name,
                            'time' => $waktu,
                            'color' => 'primary'
                        ];
                        break;
                    case 'valid':
                        $aktivitas[] = [
                            'icon' => 'check',
                            'text' => 'Verifikasi selesai: ' . $pendaftaran->user->name,
                            'time' => $waktu,
                            'color' => 'success'
                        ];
                        break;
                    case 'lulus':
                        $aktivitas[] = [
                            'icon' => 'graduation-cap',
                            'text' => 'Siswa lulus: ' . $pendaftaran->user->name,
                            'time' => $waktu,
                            'color' => 'info'
                        ];
                        break;
                    case 'tidak_valid':
                        $aktivitas[] = [
                            'icon' => 'times',
                            'text' => 'Berkas ditolak: ' . $pendaftaran->user->name,
                            'time' => $waktu,
                            'color' => 'danger'
                        ];
                        break;
                }
            }
            
            // Pastikan chartData memiliki default values
            if (empty($chartData['jurusan_labels'])) {
                $chartData['jurusan_labels'] = [];
                $chartData['jurusan_data'] = [];
            }
            if (empty($chartData['pemasukan_labels'])) {
                $chartData['pemasukan_labels'] = [];
                $chartData['pemasukan_data'] = [];
            }
            
            return view('dashboard.admin', compact('stats', 'aktivitas', 'chartData'));
        } catch (\Exception $e) {
            \Log::error('Dashboard Admin Error: ' . $e->getMessage());
            
            // Return with default empty data
            $stats = ['total_pendaftar' => 0, 'terverifikasi' => 0, 'terbayar' => 0, 'lulus' => 0];
            $aktivitas = [];
            $chartData = ['jurusan_labels' => [], 'jurusan_data' => [], 'pemasukan_labels' => [], 'pemasukan_data' => []];
            
            return view('dashboard.admin', compact('stats', 'aktivitas', 'chartData'))
                ->with('error', 'Terjadi kesalahan saat memuat data dashboard.');
        }
    }

    private function dashboardVerifikator()
    {
        return redirect()->route('verifikator.index');
    }

    private function dashboardKeuangan()
    {
        return redirect()->route('dashboard.keuangan');
    }

    private function dashboardKepalaSekolah()
    {
        $totalPendaftar = Pendaftaran::count();
        $totalJurusan = Jurusan::where('aktif', true)->count();
        $totalPemasukan = \App\Models\Pembayaran::where('status', 'verified')->sum('nominal');
        $terverifikasi = Pendaftaran::whereIn('status', ['valid', 'lulus'])->count();
        
        $kpi = [
            'total_pendaftar' => $totalPendaftar,
            'total_jurusan' => $totalJurusan,
            'gelombang_aktif' => Gelombang::where('aktif', true)->count(),
            'total_pemasukan' => $totalPemasukan,
            'rata_pendaftar_per_jurusan' => $totalJurusan > 0 ? round($totalPendaftar / $totalJurusan, 1) : 0,
            'rasio_terverifikasi' => $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0
        ];
        
        // Data jurusan dengan pendaftar (hanya yang aktif)
        $jurusanData = Jurusan::where('aktif', true)->withCount('pendaftarans')->get();
        
        // Status verifikasi dengan flow baru
        $statusData = [
            'menunggu' => Pendaftaran::where('status', 'submitted')->count(),
            'diproses' => Pendaftaran::whereIn('status', ['valid', 'belum_bayar'])->count(),
            'lulus' => Pendaftaran::where('status', 'lulus')->count(),
            'ditolak' => Pendaftaran::where('status', 'rejected')->count(),
            'ditolak_verifikator' => Pendaftaran::where('status', 'tidak_valid')->count()
        ];
        
        // Komposisi asal sekolah/wilayah
        $asalSekolah = Pendaftaran::selectRaw('asal_sekolah, COUNT(*) as total')
            ->whereNotNull('asal_sekolah')
            ->groupBy('asal_sekolah')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
            
        $asalWilayah = Pendaftaran::selectRaw('kecamatan, COUNT(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
        
        // Aktivitas terbaru
        $aktivitas = Pendaftaran::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        // Data tren 7 hari terakhir
        $trenData = Pendaftaran::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
            
        // Tren harian dengan perbandingan periode sebelumnya
        $trenHarian = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            $count = Pendaftaran::whereDate('created_at', $tanggal)->count();
            $trenHarian[] = [
                'tanggal' => $tanggal,
                'total' => $count,
                'label' => now()->subDays($i)->format('d/m')
            ];
        }
        
        return view('dashboard.kepala-sekolah', compact('kpi', 'jurusanData', 'statusData', 'aktivitas', 'trenData', 'asalSekolah', 'asalWilayah', 'trenHarian'));
    }
    
    public function getTrenData(Request $request)
    {
        $days = $request->get('days', 7);
        
        $trenData = Pendaftaran::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
            
        return response()->json([
            'labels' => $trenData->pluck('tanggal')->map(function($date) {
                return Carbon::parse($date)->format('d/m');
            })->toArray(),
            'values' => $trenData->pluck('total')->toArray()
        ]);
    }
    
    public function getKpiData(Request $request)
    {
        $totalPendaftar = Pendaftaran::count();
        $terverifikasi = Pendaftaran::whereIn('status', ['valid', 'lulus'])->count();
        
        // Komposisi asal sekolah
        $asalSekolah = Pendaftaran::selectRaw('asal_sekolah, COUNT(*) as total')
            ->whereNotNull('asal_sekolah')
            ->groupBy('asal_sekolah')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
            
        // Komposisi asal wilayah
        $asalWilayah = Pendaftaran::selectRaw('kecamatan, COUNT(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        return response()->json([
            'rasio_terverifikasi' => $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0,
            'asal_sekolah' => $asalSekolah,
            'asal_wilayah' => $asalWilayah
        ]);
    }
    
    public function getChartData(Request $request)
    {
        $days = $request->get('days', 'all');
        
        // Build query based on filter
        $query = Jurusan::where('aktif', true);
        
        if ($days !== 'all') {
            $dateFrom = now()->subDays((int)$days);
            $query = $query->withCount(['pendaftarans' => function($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            }]);
        } else {
            $query = $query->withCount('pendaftarans');
        }
        
        $jurusanData = $query->get();
        
        return response()->json([
            'labels' => $jurusanData->pluck('nama')->toArray(),
            'data' => $jurusanData->pluck('pendaftarans_count')->toArray()
        ]);
    }
}