<?php
// Test WhatsApp sederhana
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$token = env('WHATSAPP_TOKEN');
$phone = '08123456789'; // Ganti dengan nomor HP tujuan

if (!$token) {
    echo "❌ WHATSAPP_TOKEN belum diisi di .env\n";
    exit;
}

$data = [
    'target' => $phone,
    'message' => 'Test WhatsApp dari SPMB SMK Bakti Nusantara 666',
    'countryCode' => '62'
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        'Authorization: ' . $token,
        'Content-Type: application/json'
    ],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";

if ($httpCode == 200) {
    echo "✅ WhatsApp berhasil dikirim!\n";
} else {
    echo "❌ WhatsApp gagal dikirim\n";
}
?>