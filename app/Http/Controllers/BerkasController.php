<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function index(Pendaftaran $pendaftaran)
    {
        $berkas = $pendaftaran->berkas;
        return view('berkas.index', compact('pendaftaran', 'berkas'));
    }

    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'jenis' => 'required|in:ijazah,rapor,kip,kks,akta,kk,pas_foto',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('berkas', $filename, 'public');

        Berkas::create([
            'pendaftaran_id' => $pendaftaran->id,
            'jenis' => $request->jenis,
            'nama_file' => $file->getClientOriginalName(),
            'path_file' => $path,
        ]);
        
        // Show success message for photo upload
        if ($request->jenis === 'pas_foto') {
            return back()->with('success', 'Pas foto berhasil diupload! Foto akan digunakan untuk kartu pendaftaran.');
        }

        return back()->with('success', 'Berkas berhasil diupload');
    }

    public function destroy(Berkas $berkas)
    {
        Storage::disk('public')->delete($berkas->path_file);
        $berkas->delete();
        return back()->with('success', 'Berkas berhasil dihapus');
    }
}