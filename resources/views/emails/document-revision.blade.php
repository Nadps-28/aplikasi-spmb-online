<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Perbaikan Berkas Diperlukan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2563eb;">SMK Bakti Nusantara 666</h1>
            <h2 style="color: #f59e0b;">Perbaikan Berkas Diperlukan</h2>
        </div>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Berkas pendaftaran Anda dengan nomor <strong>{{ $nomor_pendaftaran }}</strong> perlu diperbaiki.</p>
        
        <div style="background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h3 style="margin-top: 0; color: #92400e;">Catatan Perbaikan:</h3>
            <p style="margin-bottom: 0;">{{ $message }}</p>
        </div>
        
        <p>Silakan login ke sistem dan perbaiki berkas sesuai dengan catatan di atas.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background: #f59e0b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Login & Perbaiki Berkas</a>
        </div>
        
        <p>Terima kasih,<br>Tim SPMB SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>