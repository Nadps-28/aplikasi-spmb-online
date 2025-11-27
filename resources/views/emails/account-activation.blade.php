<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Aktivasi Akun SPMB</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2563eb;">SMK Bakti Nusantara 666</h1>
            <h2 style="color: #64748b;">Aktivasi Akun Berhasil</h2>
        </div>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Selamat! Akun SPMB Anda telah berhasil diaktivasi.</p>
        
        <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Status:</strong> Aktif</p>
        </div>
        
        <p>Anda sekarang dapat login dan melanjutkan proses pendaftaran.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Login Sekarang</a>
        </div>
        
        <p>Terima kasih,<br>Tim SPMB SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>