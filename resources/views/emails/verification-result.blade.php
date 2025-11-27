<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Verifikasi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2563eb;">SMK Bakti Nusantara 666</h1>
            <h2 style="color: {{ $status === 'DITERIMA' ? '#059669' : '#dc2626' }};">Hasil Verifikasi</h2>
        </div>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Hasil verifikasi pendaftaran Anda telah keluar.</p>
        
        <div style="background: {{ $status === 'DITERIMA' ? '#f0fdf4' : '#fef2f2' }}; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid {{ $status === 'DITERIMA' ? '#059669' : '#dc2626' }};">
            <h3 style="margin-top: 0; color: {{ $status === 'DITERIMA' ? '#065f46' : '#991b1b' }};">Status Verifikasi:</h3>
            <p><strong>Nomor Pendaftaran:</strong> {{ $nomor_pendaftaran }}</p>
            <p><strong>Status:</strong> <span style="color: {{ $status === 'DITERIMA' ? '#059669' : '#dc2626' }}; font-weight: bold;">{{ $status }}</span></p>
            @if($message)
            <p><strong>Catatan:</strong> {{ $message }}</p>
            @endif
        </div>
        
        @if($status === 'DITERIMA')
        <p>Selamat! Anda telah diterima di SMK Bakti Nusantara 666. Silakan login untuk melihat informasi selanjutnya.</p>
        @else
        <p>Mohon maaf, pendaftaran Anda belum dapat kami terima. Silakan hubungi panitia untuk informasi lebih lanjut.</p>
        @endif
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Login ke Sistem</a>
        </div>
        
        <p>Terima kasih,<br>Tim SPMB SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>