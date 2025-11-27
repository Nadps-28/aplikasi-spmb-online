<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'menunggu_verifikasi' => Pembayaran::where('status', 'pending')->whereNotNull('bukti_bayar')->count(),
            'pembayaran_valid' => Pembayaran::where('status', 'verified')->count(),
            'pembayaran_ditolak' => Pembayaran::where('status', 'rejected')->count(),
            'pemasukan_hari_ini' => Pembayaran::where('status', 'verified')
                ->whereDate('updated_at', today())
                ->sum('nominal'),
            'total_pemasukan' => Pembayaran::where('status', 'verified')->sum('nominal'),
            'pemasukan_bulan_ini' => Pembayaran::where('status', 'verified')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->sum('nominal'),
            'pemasukan_minggu' => Pembayaran::where('status', 'verified')
                ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('nominal'),
            'tingkat_verifikasi' => $this->hitungTingkatVerifikasi()
        ];

        $pembayaran_pending = Pembayaran::with(['pendaftaran.user', 'pendaftaran.jurusan'])
            ->where('status', 'pending')
            ->whereNotNull('bukti_bayar')
            ->latest()
            ->limit(10)
            ->get();

        // Data untuk grafik pemasukan 7 hari terakhir
        $pemasukanHarian = Pembayaran::where('status', 'verified')
            ->selectRaw('DATE(updated_at) as tanggal, SUM(nominal) as total')
            ->where('updated_at', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
            
        $chartData = [
            'labels' => $pemasukanHarian->pluck('tanggal')->map(function($date) {
                return Carbon::parse($date)->format('d M');
            })->toArray(),
            'data' => $pemasukanHarian->pluck('total')->toArray()
        ];
        
        // Jika tidak ada data, buat data dummy untuk 7 hari terakhir
        if (empty($chartData['labels'])) {
            $chartData['labels'] = [];
            $chartData['data'] = [];
            for ($i = 6; $i >= 0; $i--) {
                $chartData['labels'][] = now()->subDays($i)->format('d M');
                $chartData['data'][] = 0;
            }
        }

        return view('dashboard.keuangan', compact('stats', 'pembayaran_pending', 'chartData'));
    }

    private function hitungTingkatVerifikasi()
    {
        $total = Pembayaran::count();
        if ($total == 0) return 0;
        
        $terverifikasi = Pembayaran::whereIn('status', ['verified', 'rejected'])->count();
        return round(($terverifikasi / $total) * 100);
    }

    private function hitungRataWaktuVerifikasi()
    {
        $pembayaranTerverifikasi = Pembayaran::whereIn('status', ['verified', 'rejected'])
            ->get();
            
        if ($pembayaranTerverifikasi->count() == 0) return '0 jam';
        
        $totalJam = 0;
        foreach ($pembayaranTerverifikasi as $pembayaran) {
            $created = Carbon::parse($pembayaran->created_at);
            $updated = Carbon::parse($pembayaran->updated_at);
            $totalJam += $created->diffInHours($updated);
        }
        
        $rataJam = round($totalJam / $pembayaranTerverifikasi->count(), 1);
        return $rataJam . ' jam';
    }
    public function verifikasiPembayaran(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        if (!$pendaftaran->canPaymentBeVerified()) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran tidak dapat diverifikasi pembayarannya'
            ]);
        }
        
        $status = $request->input('status') === 'terima' ? 'lunas' : 'belum_bayar';
        
        // Auto graduate untuk sekolah swasta
        $finalStatus = $status === 'lunas' ? 'lulus' : 'belum_bayar';
        
        $pendaftaran->update([
            'status' => $finalStatus,
            'payment_verified_at' => now(),
            'payment_verified_by' => auth()->id(),
            'graduated_at' => $status === 'lunas' ? now() : null,
            'graduated_by' => $status === 'lunas' ? auth()->id() : null,
            'catatan_kelulusan' => $status === 'lunas' ? 'Selamat! Anda telah diterima sebagai siswa baru. Selamat bergabung dengan keluarga besar sekolah kami!' : null
        ]);

        // Update pembayaran status
        if ($pendaftaran->pembayaran) {
            $pembayaran_status = $status === 'lunas' ? 'verified' : 'rejected';
            $pendaftaran->pembayaran->update(['status' => $pembayaran_status]);
        }

        $message = $status === 'lunas' ? 
            'Verifikasi pembayaran berhasil - Siswa LULUS dan diterima' : 
            'Pembayaran ditolak - Status: BELUM BAYAR';
            
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string'
        ]);

        $pendaftaran = $pembayaran->pendaftaran;
        
        if (!$pendaftaran->canPaymentBeVerified()) {
            return back()->withErrors(['error' => 'Pendaftaran tidak dapat diverifikasi pembayarannya']);
        }

        $status = $request->input('status');
        
        if ($status === 'verified') {
            // Auto graduate untuk sekolah swasta
            $pendaftaran->update([
                'status' => Pendaftaran::STATUS_LULUS,
                'payment_verified_at' => now(),
                'payment_verified_by' => auth()->id(),
                'graduated_at' => now(),
                'graduated_by' => auth()->id(),
                'catatan_kelulusan' => 'Selamat! Anda telah diterima sebagai siswa baru. Selamat bergabung dengan keluarga besar sekolah kami!'
            ]);
            
            $pembayaran->update([
                'status' => 'verified',
                'catatan' => $request->catatan
            ]);
            
            return back()->with('success', 'Pembayaran berhasil diverifikasi - Siswa LULUS dan diterima');
        } else {
            $pembayaran->update([
                'status' => 'rejected',
                'catatan' => $request->catatan
            ]);
            
            return back()->with('success', 'Pembayaran berhasil ditolak');
        }
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['pendaftaran.user', 'pendaftaran.jurusan']);
        return view('keuangan.show', compact('pembayaran'));
    }
}