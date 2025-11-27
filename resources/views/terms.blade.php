@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - SPMB')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card p-5">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Syarat & Ketentuan</h2>
                        <p class="text-muted">SMK Bakti Nusantara 666 - Sistem Penerimaan Murid Baru Online</p>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">1. Ketentuan Umum</h4>
                            <ul class="mb-4">
                                <li>Calon siswa wajib mengisi formulir pendaftaran dengan data yang benar dan lengkap</li>
                                <li>Setiap calon siswa hanya diperbolehkan mendaftar satu kali dalam satu gelombang</li>
                                <li>Data yang telah disubmit tidak dapat diubah kecuali atas persetujuan panitia</li>
                                <li>Calon siswa bertanggung jawab atas kebenaran data yang dimasukkan</li>
                            </ul>

                            <h4 class="fw-bold mb-3">2. Persyaratan Pendaftaran</h4>
                            <ul class="mb-4">
                                <li>Lulusan SMP/MTs atau sederajat</li>
                                <li>Memiliki NISN (Nomor Induk Siswa Nasional) yang valid</li>
                                <li>Memiliki NIK (Nomor Induk Kependudukan) yang valid</li>
                                <li>Berusia maksimal 18 tahun pada saat pendaftaran</li>
                                <li>Sehat jasmani dan rohani</li>
                            </ul>

                            <h4 class="fw-bold mb-3">3. Dokumen yang Diperlukan</h4>
                            <ul class="mb-4">
                                <li>Ijazah SMP/MTs atau Surat Keterangan Lulus (SKL)</li>
                                <li>Kartu Keluarga (KK) - berisi NIK siswa dan keluarga</li>
                                <li>Akta Kelahiran - berisi NIK siswa</li>
                                <li>Kartu Tanda Penduduk (KTP) orang tua/wali</li>
                                <li>Pas foto terbaru ukuran 3x4 (2 lembar)</li>
                                <li>Surat keterangan sehat dari dokter</li>
                            </ul>

                            <h4 class="fw-bold mb-3">4. Proses Seleksi</h4>
                            <ul class="mb-4">
                                <li>Seleksi berdasarkan nilai rapor dan tes masuk</li>
                                <li>Verifikasi dokumen oleh tim verifikator</li>
                                <li>Wawancara (jika diperlukan)</li>
                                <li>Pengumuman hasil seleksi melalui sistem online</li>
                            </ul>

                            <h4 class="fw-bold mb-3">5. Pembayaran</h4>
                            <ul class="mb-4">
                                <li>Biaya pendaftaran sebesar Rp 5.500.000 (tidak dapat dikembalikan)</li>
                                <li>Pembayaran dilakukan melalui transfer bank atau tunai</li>
                                <li>Bukti pembayaran wajib diupload ke sistem</li>
                                <li>Pendaftaran dianggap sah setelah pembayaran dikonfirmasi</li>
                            </ul>

                            <h4 class="fw-bold mb-3">6. Jadwal Penting</h4>
                            <ul class="mb-4">
                                <li>Pendaftaran online: sesuai jadwal gelombang</li>
                                <li>Verifikasi dokumen: 3 hari kerja setelah upload</li>
                                <li>Konfirmasi pembayaran: maksimal 2 hari kerja</li>
                                <li>Pengumuman hasil: sesuai jadwal yang ditentukan</li>
                            </ul>

                            <h4 class="fw-bold mb-3">7. Hak dan Kewajiban</h4>
                            <p class="mb-2"><strong>Hak Calon Siswa:</strong></p>
                            <ul class="mb-3">
                                <li>Mendapat informasi yang jelas tentang proses seleksi</li>
                                <li>Mendapat perlakuan yang adil dalam proses seleksi</li>
                                <li>Mengajukan komplain jika terdapat ketidaksesuaian</li>
                            </ul>

                            <p class="mb-2"><strong>Kewajiban Calon Siswa:</strong></p>
                            <ul class="mb-4">
                                <li>Mengisi data dengan benar dan lengkap</li>
                                <li>Mengupload dokumen sesuai ketentuan</li>
                                <li>Melakukan pembayaran tepat waktu</li>
                                <li>Mengikuti seluruh tahapan seleksi</li>
                            </ul>

                            <h4 class="fw-bold mb-3">8. Sanksi</h4>
                            <ul class="mb-4">
                                <li>Pemalsuan data akan mengakibatkan diskualifikasi</li>
                                <li>Keterlambatan pembayaran dapat membatalkan pendaftaran</li>
                                <li>Tidak mengikuti tahapan seleksi dianggap mengundurkan diri</li>
                            </ul>

                            <h4 class="fw-bold mb-3">9. Kebijakan Privasi</h4>
                            <ul class="mb-4">
                                <li>Data pribadi akan dijaga kerahasiaannya</li>
                                <li>Data hanya digunakan untuk keperluan seleksi</li>
                                <li>Data tidak akan disebarluaskan kepada pihak ketiga</li>
                            </ul>

                            <h4 class="fw-bold mb-3">10. Ketentuan Lain</h4>
                            <ul class="mb-4">
                                <li>Panitia berhak mengubah ketentuan sewaktu-waktu</li>
                                <li>Keputusan panitia bersifat final dan tidak dapat diganggu gugat</li>
                                <li>Hal-hal yang belum diatur akan ditentukan kemudian</li>
                            </ul>

                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Informasi Kontak:</strong><br>
                                Email: info@smkbaktinusantara666.sch.id<br>
                                Telepon: (021) 666-7777<br>
                                WhatsApp: 0812-3456-7890
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <div class="d-flex flex-column flex-md-row justify-content-center gap-2">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                                </a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                                </a>
                            @endauth
                            <button onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="fas fa-print me-2"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection