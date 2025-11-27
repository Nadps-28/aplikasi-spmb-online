<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function masterData()
    {
        $jurusans = Jurusan::all();
        $gelombangs = Gelombang::all();
        return view('admin.master-data', compact('jurusans', 'gelombangs'));
    }

    public function monitoring(Request $request)
    {
        $query = Pendaftaran::with(['user', 'jurusan', 'gelombang', 'berkas']);
        
        // Filter by status if provided
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        $pendaftarans = $query->orderBy('created_at', 'desc')->paginate(20);
        $pendaftarans->appends($request->query());
        

        
        return view('admin.monitoring', compact('pendaftarans'));
    }

    public function petaSebaran()
    {
        $pendaftarans = Pendaftaran::with(['jurusan', 'user'])->get();
        
        // Generate coordinates based on actual address data
        $pendaftarans = $pendaftarans->map(function ($pendaftaran) {
            if (!$pendaftaran->latitude || !$pendaftaran->longitude) {
                // Use actual address data from pendaftaran
                $kecamatan = $pendaftaran->kecamatan ?? '';
                $kelurahan = $pendaftaran->kelurahan ?? '';
                $alamat = $pendaftaran->alamat ?? '';
                
                // Generate coordinates based on actual location data
                $coordinates = $this->getCoordinatesByArea($kecamatan, $kelurahan, $alamat);
                $pendaftaran->latitude = $coordinates['lat'];
                $pendaftaran->longitude = $coordinates['lng'];
            }
            return $pendaftaran;
        });
        
        // Statistics
        $stats = [
            'total_pendaftar' => $pendaftarans->count(),
            'dengan_koordinat' => $pendaftarans->whereNotNull('latitude')->count(),
            'per_jurusan' => $pendaftarans->groupBy('jurusan.nama')->map->count(),
            'per_kecamatan' => $pendaftarans->groupBy('kecamatan')->map->count()->sortDesc()->take(10),
            'per_status' => $pendaftarans->groupBy('status')->map->count()
        ];
        
        return view('admin.peta-sebaran', compact('pendaftarans', 'stats'));
    }
    
    private function getCoordinatesByArea($kecamatan, $kelurahan, $alamat = '')
    {
        // Detailed coordinates for West Java areas
        $areaCoordinates = [
            // Bandung Raya
            'bandung' => ['lat' => -6.9175, 'lng' => 107.6191],
            'cimahi' => ['lat' => -6.8722, 'lng' => 107.5422],
            'bandung barat' => ['lat' => -6.8611, 'lng' => 107.4847],
            'bandung timur' => ['lat' => -6.9147, 'lng' => 107.7186],
            'bandung selatan' => ['lat' => -7.0261, 'lng' => 107.5397],
            'bandung utara' => ['lat' => -6.8597, 'lng' => 107.6036],
            
            // Kecamatan di Bandung
            'cicendo' => ['lat' => -6.9036, 'lng' => 107.5831],
            'sukajadi' => ['lat' => -6.8944, 'lng' => 107.5889],
            'coblong' => ['lat' => -6.8958, 'lng' => 107.6167],
            'andir' => ['lat' => -6.9167, 'lng' => 107.5833],
            'astana anyar' => ['lat' => -6.9333, 'lng' => 107.5833],
            'bojongloa kaler' => ['lat' => -6.9333, 'lng' => 107.5667],
            'bojongloa kidul' => ['lat' => -6.9500, 'lng' => 107.5667],
            'bandung kulon' => ['lat' => -6.9167, 'lng' => 107.5667],
            'kiaracondong' => ['lat' => -6.9333, 'lng' => 107.6500],
            'batununggal' => ['lat' => -6.9500, 'lng' => 107.6167],
            'sumur bandung' => ['lat' => -6.9167, 'lng' => 107.6167],
            'babakan ciparay' => ['lat' => -6.9667, 'lng' => 107.6000],
            'cibeunying kaler' => ['lat' => -6.8833, 'lng' => 107.6333],
            'cibeunying kidul' => ['lat' => -6.9000, 'lng' => 107.6333],
            'cidadap' => ['lat' => -6.8667, 'lng' => 107.6000],
            'lengkong' => ['lat' => -6.9333, 'lng' => 107.6167],
            'regol' => ['lat' => -6.9500, 'lng' => 107.5833],
            'ujung berung' => ['lat' => -6.9167, 'lng' => 107.7000],
            'arcamanik' => ['lat' => -6.9000, 'lng' => 107.7167],
            'antapani' => ['lat' => -6.9167, 'lng' => 107.6667],
            'mandalajati' => ['lat' => -6.8833, 'lng' => 107.6833],
            'gedebage' => ['lat' => -6.9500, 'lng' => 107.7167],
            'buahbatu' => ['lat' => -6.9667, 'lng' => 107.6500],
            'rancasari' => ['lat' => -6.9833, 'lng' => 107.6833],
            'margahayu' => ['lat' => -6.9833, 'lng' => 107.6167],
            'margacinta' => ['lat' => -6.9667, 'lng' => 107.5833],
            
            // Kelurahan populer
            'dago' => ['lat' => -6.8667, 'lng' => 107.6167],
            'dipatiukur' => ['lat' => -6.8833, 'lng' => 107.6000],
            'lebakgede' => ['lat' => -6.8833, 'lng' => 107.6167],
            'lebaksiliwangi' => ['lat' => -6.8667, 'lng' => 107.6000],
            'sadangserang' => ['lat' => -6.8667, 'lng' => 107.5833],
            'sekeloa' => ['lat' => -6.8833, 'lng' => 107.6333],
            'gegerkalong' => ['lat' => -6.8500, 'lng' => 107.6000],
            'isola' => ['lat' => -6.8667, 'lng' => 107.6333],
            'sukarasa' => ['lat' => -6.8500, 'lng' => 107.6167],
            'ciumbuleuit' => ['lat' => -6.8500, 'lng' => 107.6000],
            'hegarmanah' => ['lat' => -6.8667, 'lng' => 107.6167],
            'pasteur' => ['lat' => -6.9000, 'lng' => 107.5833],
            'sukabungah' => ['lat' => -6.9000, 'lng' => 107.5667],
            'sukagalih' => ['lat' => -6.9167, 'lng' => 107.5667],
            'sukawarna' => ['lat' => -6.9000, 'lng' => 107.5500],
            'babakan' => ['lat' => -6.9333, 'lng' => 107.5833],
            'jamika' => ['lat' => -6.9167, 'lng' => 107.5833],
            'kebon pisang' => ['lat' => -6.9167, 'lng' => 107.6000],
            'maleber' => ['lat' => -6.9333, 'lng' => 107.5667],
            'pajajaran' => ['lat' => -6.9000, 'lng' => 107.6000],
            'pamoyanan' => ['lat' => -6.9167, 'lng' => 107.6000],
            'arjuna' => ['lat' => -6.9000, 'lng' => 107.6167],
            'husen sastranegara' => ['lat' => -6.9000, 'lng' => 107.5833],
            'neglasari' => ['lat' => -6.9167, 'lng' => 107.5833],
            'turangga' => ['lat' => -6.9333, 'lng' => 107.6000],
            
            // Kabupaten sekitar
            'sumedang' => ['lat' => -6.8572, 'lng' => 107.9167],
            'garut' => ['lat' => -7.2125, 'lng' => 107.8958],
            'tasikmalaya' => ['lat' => -7.3506, 'lng' => 108.2167],
            'cianjur' => ['lat' => -6.8167, 'lng' => 107.1333],
            'sukabumi' => ['lat' => -6.9278, 'lng' => 106.9306],
            'bogor' => ['lat' => -6.5944, 'lng' => 106.7892],
            'depok' => ['lat' => -6.4025, 'lng' => 106.7942],
            'bekasi' => ['lat' => -6.2383, 'lng' => 106.9756],
            'karawang' => ['lat' => -6.3061, 'lng' => 107.3019],
            'purwakarta' => ['lat' => -6.5569, 'lng' => 107.4431],
            'subang' => ['lat' => -6.5694, 'lng' => 107.7583],
            
            // Kecamatan di Kabupaten Bandung
            'cileunyi' => ['lat' => -6.9500, 'lng' => 107.7500],
            'cinunuk' => ['lat' => -6.9500, 'lng' => 107.7500],
            'rancaekek' => ['lat' => -6.9667, 'lng' => 107.7667],
            'majalaya' => ['lat' => -7.0500, 'lng' => 107.7500],
            'solokanjeruk' => ['lat' => -7.0167, 'lng' => 107.7167],
            'paseh' => ['lat' => -7.1000, 'lng' => 107.7667],
            'ibun' => ['lat' => -7.1167, 'lng' => 107.8000],
            'soreang' => ['lat' => -7.0333, 'lng' => 107.5167],
            'katapang' => ['lat' => -7.0167, 'lng' => 107.5333],
            'banjaran' => ['lat' => -7.0500, 'lng' => 107.5833],
            'arjasari' => ['lat' => -7.0833, 'lng' => 107.5500],
            'pangalengan' => ['lat' => -7.1833, 'lng' => 107.5833],
            'kertasari' => ['lat' => -7.2167, 'lng' => 107.6000],
            'pacet' => ['lat' => -7.2000, 'lng' => 107.6333],
            'ciwidey' => ['lat' => -7.1500, 'lng' => 107.5000],
            'rancabali' => ['lat' => -7.1333, 'lng' => 107.4000],
            'pasirjambu' => ['lat' => -7.1167, 'lng' => 107.4333],
            'cimaung' => ['lat' => -7.0667, 'lng' => 107.4833],
            'padalarang' => ['lat' => -6.8333, 'lng' => 107.4833],
            'batujajar' => ['lat' => -6.8167, 'lng' => 107.4667],
            'cihampelas' => ['lat' => -6.7833, 'lng' => 107.4833],
            'cikalongwetan' => ['lat' => -6.7500, 'lng' => 107.4667],
            'cipeundeuy' => ['lat' => -6.7167, 'lng' => 107.4833],
            'ngamprah' => ['lat' => -6.7833, 'lng' => 107.5167],
            'lembang' => ['lat' => -6.8167, 'lng' => 107.6167],
            'parongpong' => ['lat' => -6.7833, 'lng' => 107.5833],
            'cisarua' => ['lat' => -6.7500, 'lng' => 107.5833]
        ];
        
        // Create search key from kecamatan, kelurahan, and alamat
        $searchKey = strtolower($kecamatan . ' ' . $kelurahan . ' ' . $alamat);
        
        // Find best matching area
        $bestMatch = null;
        $bestScore = 0;
        
        foreach ($areaCoordinates as $area => $coord) {
            // Check exact match first
            if (stripos($searchKey, $area) !== false) {
                $score = strlen($area);
                if ($score > $bestScore) {
                    $bestMatch = $coord;
                    $bestScore = $score;
                }
            }
        }
        
        // If no match, try partial matching
        if (!$bestMatch) {
            foreach ($areaCoordinates as $area => $coord) {
                $areaWords = explode(' ', $area);
                foreach ($areaWords as $word) {
                    if (strlen($word) > 3 && stripos($searchKey, $word) !== false) {
                        $bestMatch = $coord;
                        break 2;
                    }
                }
            }
        }
        
        // Default to central Bandung if no match found
        if (!$bestMatch) {
            $bestMatch = $areaCoordinates['bandung'];
        }
        
        // Add smaller random offset for more precise location
        return [
            'lat' => $bestMatch['lat'] + (rand(-20, 20) / 10000), // ±0.002 degrees (~200m)
            'lng' => $bestMatch['lng'] + (rand(-20, 20) / 10000)  // ±0.002 degrees (~200m)
        ];
    }

    public function storeJurusan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jurusans,nama',
            'biaya_daftar' => 'required|numeric|min:100000|max:50000000',
        ], [
            'nama.unique' => 'Nama jurusan sudah ada',
            'biaya_daftar.min' => 'Biaya pendaftaran minimal Rp 100.000',
            'biaya_daftar.max' => 'Biaya pendaftaran maksimal Rp 50.000.000'
        ]);

        Jurusan::create([
            'nama' => $request->nama,
            'biaya_daftar' => $request->biaya_daftar,
            'aktif' => true
        ]);
        
        return back()->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function storeGelombang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:gelombangs,nama',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ], [
            'nama.unique' => 'Nama gelombang sudah ada',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai'
        ]);

        Gelombang::create([
            'nama' => $request->nama,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'aktif' => $request->has('aktif')
        ]);
        
        return back()->with('success', 'Gelombang berhasil ditambahkan');
    }
    
    public function toggleGelombang(Request $request, $id)
    {
        $gelombang = Gelombang::findOrFail($id);
        $gelombang->update(['aktif' => !$gelombang->aktif]);
        
        $status = $gelombang->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Gelombang {$gelombang->nama} berhasil {$status}");
    }
    
    public function graduateStudent(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        if ($pendaftaran->status !== 'valid') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pendaftaran dengan status VALID yang dapat diluluskan manual'
            ]);
        }
        
        $request->validate([
            'catatan' => 'required|string|min:10|max:500'
        ]);
        
        $pendaftaran->update([
            'status' => 'lulus',
            'graduated_at' => now(),
            'graduated_by' => auth()->id(),
            'catatan_kelulusan' => $request->catatan
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pendaftar berhasil diluluskan - Status LULUS'
        ]);
    }
    
    public function autoGraduateAll()
    {
        // Sistem otomatis sudah meluluskan siswa setelah pembayaran
        // Method ini untuk emergency graduation jika ada yang tertinggal
        $pendaftarans = Pendaftaran::whereHas('pembayaran', function($q) {
            $q->where('status', 'verified');
        })->where('status', '!=', 'lulus')->get();
        
        $graduated = 0;
        foreach ($pendaftarans as $pendaftaran) {
            $pendaftaran->update([
                'status' => 'lulus',
                'graduated_at' => now(),
                'graduated_by' => auth()->id(),
                'catatan_kelulusan' => 'Selamat! Anda telah diterima sebagai siswa baru. Selamat bergabung dengan keluarga besar sekolah kami!'
            ]);
            $graduated++;
        }
        
        return response()->json([
            'success' => true,
            'message' => $graduated > 0 ? "Berhasil meluluskan {$graduated} pendaftar yang tertinggal" : "Semua siswa sudah lulus otomatis"
        ]);
    }
    
    public function updateJurusan(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255|unique:jurusans,nama,' . $id,
            'biaya_daftar' => 'required|numeric|min:100000|max:50000000',
            'aktif' => 'boolean'
        ]);
        
        $jurusan->update($request->only(['nama', 'biaya_daftar', 'aktif']));
        
        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil diperbarui'
        ]);
    }
    
    public function deleteJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        
        if ($jurusan->pendaftarans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jurusan tidak dapat dihapus karena sudah ada pendaftar'
            ]);
        }
        
        $jurusan->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil dihapus'
        ]);
    }
}