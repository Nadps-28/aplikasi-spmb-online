<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reminder: Lengkapi Pendaftaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2563eb;">SMK Bakti Nusantara 666</h1>
            <h2 style="color: #f59e0b;">Reminder: Lengkapi Pendaftaran</h2>
        </div>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Kami mengingatkan bahwa pendaftaran Anda belum lengkap dan perlu segera diselesaikan.</p>
        
        <div style="background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h3 style="margin-top: 0; color: #92400e;">Status Pendaftaran:</h3>
            <p><strong>Nomor Pendaftaran:</strong> {{ $nomor_pendaftaran }}</p>
            <p><strong>Status:</strong> Belum Lengkap</p>
            <p><strong>Waktu Tersisa:</strong> {{ $days_left }} hari</p>
        </div>
        
        <div style="background: #fee2e2; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #991b1b;">Yang Perlu Dilakukan:</h3>
            <ul>
                <li>Lengkapi data pribadi</li>
                <li>Upload berkas yang diperlukan</li>
                <li>Submit pendaftaran untuk verifikasi</li>
            </ul>
        </div>
        
        <p>Jangan sampai terlewat! Segera login dan lengkapi pendaftaran Anda.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background: #f59e0b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Lengkapi Pendaftaran</a>
        </div>
        
        <p>Terima kasih,<br>Tim SPMB SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>