<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class VerifikatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'jurusan', 'berkas']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['submitted', 'valid', 'tidak_valid']);
        }

        // Filter berdasarkan jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan_id', $request->jurusan);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nomor_pendaftaran', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $pendaftarans = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $jurusans = Jurusan::where('aktif', true)->get();

        return view('verifikator.index', compact('pendaftarans', 'jurusans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['user', 'jurusan', 'gelombang', 'berkas']);
        return view('verifikator.show', compact('pendaftaran'));
    }

    public function verifikasi(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'catatan' => 'nullable|string'
        ]);

        // Verifikator hanya bisa mengubah status dari submitted ke valid
        if (!$pendaftaran->canBeVerified()) {
            return back()->withErrors(['error' => 'Pendaftaran tidak dapat diverifikasi']);
        }

        $pendaftaran->update([
            'status' => Pendaftaran::STATUS_VALID,
            'catatan_verifikasi' => $request->catatan,
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);
        
        // Buat record pembayaran jika belum ada
        $pembayaran = $pendaftaran->pembayaran;
        if (!$pembayaran) {
            \App\Models\Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nominal' => $pendaftaran->jurusan->biaya_daftar ?? 0,
                'status' => 'pending'
            ]);
        }

        return back()->with('success', 'Berkas berhasil diverifikasi sebagai VALID');
    }

    public function tolak(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        if (!$pendaftaran->canBeVerified()) {
            return back()->withErrors(['error' => 'Pendaftaran tidak dapat ditolak']);
        }

        $pendaftaran->update([
            'status' => Pendaftaran::STATUS_TIDAK_VALID,
            'catatan_verifikasi' => $request->catatan,
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        return back()->with('success', 'Berkas ditolak - status TIDAK VALID');
    }
}