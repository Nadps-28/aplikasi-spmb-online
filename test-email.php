<?php
// Test email sederhana
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email dari SPMB SMK Bakti Nusantara 666', function ($message) {
        $message->to('test@example.com') // Ganti dengan email tujuan
                ->subject('Test Email SPMB');
    });
    
    echo "✅ Email berhasil dikirim!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>