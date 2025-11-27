<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update: Pembayaran Sedang Diverifikasi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2563eb;">SMK Bakti Nusantara 666</h1>
            <h2 style="color: #059669;">Update: Pembayaran Sedang Diverifikasi</h2>
        </div>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Terima kasih telah mengupload bukti pembayaran. Saat ini pembayaran Anda sedang dalam proses verifikasi.</p>
        
        <div style="background: #f0fdf4; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #059669;">
            <h3 style="margin-top: 0; color: #065f46;">Status Terkini:</h3>
            <p><strong>Nomor Pendaftaran:</strong> {{ $nomor_pendaftaran }}</p>
            <p><strong>Status:</strong> Pembayaran Sedang Diverifikasi</p>
            <p><strong>Estimasi Verifikasi:</strong> 1-2 hari kerja</p>
        </div>
        
        <div style="background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #92400e;">Yang Perlu Anda Lakukan:</h3>
            <ul>
                <li>Tunggu konfirmasi verifikasi pembayaran</li>
                <li>Pantau status melalui dashboard</li>
                <li>Siapkan diri untuk tahap selanjutnya</li>
            </ul>
        </div>
        
        <p>Kami akan segera menginformasikan hasil verifikasi pembayaran Anda.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Cek Status Pendaftaran</a>
        </div>
        
        <p>Terima kasih atas kesabaran Anda,<br>Tim SPMB SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>