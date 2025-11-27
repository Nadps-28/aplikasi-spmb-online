<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instruksi Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2563eb;">SMK Bakti Nusantara 666</h1>
            <h2 style="color: #059669;">Instruksi Pembayaran</h2>
        </div>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Selamat! Berkas pendaftaran Anda telah diverifikasi dan diterima.</p>
        
        <div style="background: #f0fdf4; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #059669;">
            <h3 style="margin-top: 0; color: #065f46;">Detail Pembayaran:</h3>
            <p><strong>Nomor Pendaftaran:</strong> {{ $nomor_pendaftaran }}</p>
            <p><strong>Jurusan:</strong> {{ $jurusan }}</p>
            <p><strong>Biaya Pendaftaran:</strong> {{ $biaya }}</p>
        </div>
        
        <div style="background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #92400e;">Cara Pembayaran:</h3>
            <ol>
                <li>Lakukan pembayaran sebesar <strong>{{ $biaya }}</strong></li>
                <li>Simpan bukti pembayaran (foto/screenshot)</li>
                <li>Login ke sistem SPMB</li>
                <li>Upload bukti pembayaran</li>
                <li>Tunggu verifikasi dari tim keuangan</li>
            </ol>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Upload Bukti Pembayaran</a>
        </div>
        
        <p>Terima kasih,<br>Tim SPMB SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>