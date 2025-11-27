<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Email</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f8fafc; }
        .container { max-width: 600px; margin: 0 auto; background: white; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; font-weight: 600; }
        .content { padding: 40px 30px; }
        .otp-box { background: #f8fafc; border: 2px dashed #667eea; border-radius: 12px; padding: 30px; text-align: center; margin: 30px 0; }
        .otp-code { font-size: 36px; font-weight: 700; color: #667eea; letter-spacing: 8px; margin: 10px 0; }
        .footer { background: #f8fafc; padding: 20px 30px; text-align: center; color: #64748b; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 SMK Bakti Nusantara 666</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0;">Sistem Penerimaan Mahasiswa Baru</p>
        </div>
        
        <div class="content">
            <h2 style="color: #1e293b; margin-bottom: 20px;">Kode Verifikasi Email</h2>
            
            @if($name)
            <p>Halo <strong>{{ $name }}</strong>,</p>
            @endif
            
            <p style="color: #64748b; line-height: 1.6;">
                Terima kasih telah mendaftar di SPMB SMK Bakti Nusantara 666. 
                Gunakan kode verifikasi berikut untuk mengaktifkan akun Anda:
            </p>
            
            <div class="otp-box">
                <p style="margin: 0; color: #64748b; font-size: 14px;">Kode Verifikasi Anda</p>
                <div class="otp-code">{{ $otp }}</div>
                <p style="margin: 0; color: #64748b; font-size: 12px;">Berlaku selama 5 menit</p>
            </div>
            
            <p style="color: #64748b; line-height: 1.6;">
                Jika Anda tidak melakukan pendaftaran, abaikan email ini.
            </p>
            
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <p style="margin: 0; color: #92400e; font-size: 14px;">
                    <strong>⚠️ Penting:</strong> Jangan bagikan kode ini kepada siapa pun untuk keamanan akun Anda.
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p>© 2024 SMK Bakti Nusantara 666. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>