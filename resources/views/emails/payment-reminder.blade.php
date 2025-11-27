<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reminder: Segera Lakukan Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2563eb;">SMK Bakti Nusantara 666</h1>
            <h2 style="color: #dc2626;">Reminder: Segera Lakukan Pembayaran</h2>
        </div>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Berkas pendaftaran Anda telah diverifikasi. Namun, pembayaran belum dilakukan.</p>
        
        <div style="background: #fee2e2; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc2626;">
            <h3 style="margin-top: 0; color: #991b1b;">Detail Pembayaran:</h3>
            <p><strong>Nomor Pendaftaran:</strong> {{ $nomor_pendaftaran }}</p>
            <p><strong>Jurusan:</strong> {{ $jurusan }}</p>
            <p><strong>Biaya Pendaftaran:</strong> {{ $biaya }}</p>
            <p><strong>Status:</strong> Menunggu Pembayaran</p>
        </div>
        
        <div style="background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #92400e;">Langkah Selanjutnya:</h3>
            <ol>
                <li>Lakukan pembayaran sebesar <strong>{{ $biaya }}</strong></li>
                <li>Simpan bukti pembayaran</li>
                <li>Login ke sistem dan upload bukti pembayaran</li>
                <li>Tunggu verifikasi dari tim keuangan</li>
            </ol>
        </div>
        
        <p><strong>Penting:</strong> Segera lakukan pembayaran untuk melanjutkan proses pendaftaran Anda.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background: #dc2626; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Upload Bukti Pembayaran</a>
        </div>
        
        <p>Terima kasih,<br>Tim SPMB SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>