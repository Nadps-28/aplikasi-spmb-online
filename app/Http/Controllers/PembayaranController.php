<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function show(Pendaftaran $pendaftaran)
    {
        $pembayaran = $pendaftaran->pembayaran;
        return view('pembayaran.show', compact('pendaftaran', 'pembayaran'));
    }

    public function uploadBukti(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('bukti_bayar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pembayaran', $filename, 'public');

        $pembayaran = $pendaftaran->pembayaran;
        if (!$pembayaran) {
            $pembayaran = Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nominal' => 5500000, // Rp 5.500.000 seragam untuk semua jurusan
                'status' => 'pending',
            ]);
        }

        $pembayaran->update([
            'bukti_bayar' => $path,
            'tanggal_bayar' => now('Asia/Jakarta'),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string',
        ]);

        $pembayaran->update($request->all());

        if ($request->status === 'verified') {
            $pembayaran->pendaftaran->update(['status' => 'verifikasi_keuangan']);
        } elseif ($request->status === 'rejected') {
            $pembayaran->pendaftaran->update(['status' => 'menunggu_bayar']);
        }

        return back()->with('success', 'Pembayaran berhasil diverifikasi');
    }
}