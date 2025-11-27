<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - SPMB</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #4ecdc4, #3dd5d0);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 SPMB Online</h1>
            <p>Reset Password</p>
        </div>
        
        <div class="content">
            <h2>Halo!</h2>
            <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">Reset Password</a>
            </div>
            
            <p>Link reset password ini akan kedaluwarsa dalam 60 menit.</p>
            
            <p>Jika Anda tidak meminta reset password, tidak ada tindakan lebih lanjut yang diperlukan.</p>
            
            <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
            
            <p style="font-size: 14px; color: #6c757d;">
                Jika Anda mengalami masalah mengklik tombol "Reset Password", salin dan tempel URL berikut ke browser web Anda:
            </p>
            <p style="font-size: 12px; word-break: break-all; color: #6c757d;">
                {{ $url }}
            </p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} SPMB Online. Semua hak dilindungi.</p>
            <p>Email ini dikirim otomatis, mohon jangan membalas.</p>
        </div>
    </div>
</body>
</html>