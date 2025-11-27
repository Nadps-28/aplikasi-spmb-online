<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function create()
    {
        $jurusans = Jurusan::where('aktif', true)->get();
        // Hanya tampilkan gelombang yang aktif dan dalam periode waktu
        $gelombangs = Gelombang::available()->get();
        return view('pendaftaran.create', compact('jurusans', 'gelombangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'gelombang_id' => 'required|exists:gelombangs,id',
            'nik' => 'required|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'kodepos' => 'required|string|max:10',
            'asal_sekolah' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'phone_ortu' => 'required|string|max:15',
        ]);
        
        // Sekolah swasta tidak ada batasan kuota
        
        // Validasi gelombang masih dalam periode aktif
        $gelombang = Gelombang::find($request->gelombang_id);
        if (!$gelombang || !$gelombang->isActive()) {
            return back()->withErrors(['gelombang_id' => 'Gelombang pendaftaran tidak dalam periode aktif.'])->withInput();
        }

        $nomorPendaftaran = 'SPMB' . date('Y') . str_pad(Pendaftaran::count() + 1, 4, '0', STR_PAD_LEFT);

        Pendaftaran::create(array_merge($request->all(), [
            'user_id' => Auth::id(),
            'nomor_pendaftaran' => $nomorPendaftaran,
            'status' => Pendaftaran::STATUS_DRAFT
        ]));

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil disimpan');
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('pendaftaran.show', compact('pendaftaran'));
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        $jurusans = Jurusan::where('aktif', true)->get();
        $gelombangs = Gelombang::where('aktif', true)->get();
        return view('pendaftaran.edit', compact('pendaftaran', 'jurusans', 'gelombangs'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        if (!$pendaftaran->canEdit()) {
            return back()->with('error', 'Pendaftaran tidak dapat diubah');
        }

        $pendaftaran->update($request->all());
        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil diperbarui');
    }

    public function submit(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status !== Pendaftaran::STATUS_DRAFT) {
            return back()->with('error', 'Pendaftaran tidak dapat dikirim');
        }
        
        $pendaftaran->update(['status' => Pendaftaran::STATUS_SUBMITTED]);
        return back()->with('success', 'Pendaftaran berhasil dikirim untuk verifikasi');
    }
}