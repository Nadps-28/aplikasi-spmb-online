<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendAccountActivation(User $user)
    {
        $this->sendEmail($user->email, 'Aktivasi Akun SPMB', 'emails.account-activation', [
            'name' => $user->name,
            'email' => $user->email
        ]);
        
        // Only send WhatsApp if phone number exists
        if ($user->phone) {
            $this->sendWhatsApp($user->phone, "Halo {$user->name}, akun SPMB Anda telah berhasil diaktivasi. Silakan login untuk melanjutkan pendaftaran.");
        }
        
        Log::info("Account activation notification sent to {$user->email}");
    }
    
    public function sendDocumentRevision(Pendaftaran $pendaftaran, $message)
    {
        $user = $pendaftaran->user;
        
        $this->sendEmail($user->email, 'Perbaikan Berkas Diperlukan', 'emails.document-revision', [
            'name' => $pendaftaran->nama_lengkap,
            'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
            'message' => $message
        ]);
        
        $this->sendWhatsApp($user->phone, "Halo {$pendaftaran->nama_lengkap}, berkas pendaftaran Anda perlu diperbaiki. Pesan: {$message}. Silakan login untuk memperbaiki berkas.");
        
        Log::info("Document revision notification sent to {$user->email}");
    }
    
    public function sendPaymentInstructions(Pendaftaran $pendaftaran)
    {
        $user = $pendaftaran->user;
        
        $this->sendEmail($user->email, 'Instruksi Pembayaran', 'emails.payment-instructions', [
            'name' => $pendaftaran->nama_lengkap,
            'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
            'jurusan' => $pendaftaran->jurusan->nama,
            'biaya' => 'Rp 5.500.000'
        ]);
        
        $this->sendWhatsApp($user->phone, "Halo {$pendaftaran->nama_lengkap}, berkas Anda telah diverifikasi. Silakan lakukan pembayaran sebesar Rp 5.500.000 dan upload bukti pembayaran.");
        
        Log::info("Payment instructions sent to {$user->email}");
    }
    
    public function sendVerificationResult(Pendaftaran $pendaftaran, $status, $message = null)
    {
        $user = $pendaftaran->user;
        $statusText = $status === 'diterima' ? 'DITERIMA' : 'DITOLAK';
        
        $this->sendEmail($user->email, "Hasil Verifikasi - {$statusText}", 'emails.verification-result', [
            'name' => $pendaftaran->nama_lengkap,
            'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
            'status' => $statusText,
            'message' => $message
        ]);
        
        $whatsappMessage = "Halo {$pendaftaran->nama_lengkap}, hasil verifikasi pendaftaran Anda: {$statusText}.";
        if ($message) {
            $whatsappMessage .= " Catatan: {$message}";
        }
        
        $this->sendWhatsApp($user->phone, $whatsappMessage);
        
        Log::info("Verification result notification sent to {$user->email}");
    }
    
    private function sendEmail($to, $subject, $template, $data)
    {
        $notificationLog = NotificationLog::create([
            'user_id' => isset($data['user_id']) ? $data['user_id'] : null,
            'type' => $template,
            'channel' => 'email',
            'recipient' => $to,
            'subject' => $subject,
            'message' => json_encode($data),
            'status' => 'pending'
        ]);

        try {
            Mail::send($template, $data, function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
            
            $notificationLog->update([
                'status' => 'sent',
                'sent_at' => now()
            ]);
        } catch (\Exception $e) {
            $notificationLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            Log::error("Failed to send email to {$to}: " . $e->getMessage());
        }
    }
    
    private function sendWhatsApp($phone, $message)
    {
        // Skip if phone is null or empty
        if (!$phone) {
            Log::info("WhatsApp skipped: No phone number provided");
            return;
        }
        
        $notificationLog = NotificationLog::create([
            'type' => 'whatsapp_message',
            'channel' => 'whatsapp',
            'recipient' => $phone,
            'message' => $message,
            'status' => 'pending'
        ]);

        try {
            $apiUrl = env('WHATSAPP_API_URL');
            $token = env('WHATSAPP_TOKEN');
            
            if (!$apiUrl || !$token) {
                $notificationLog->update([
                    'status' => 'failed',
                    'error_message' => 'WhatsApp API not configured'
                ]);
                Log::info("WhatsApp (not configured): {$phone} - {$message}");
                return;
            }
            
            $data = [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62'
            ];
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
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
            curl_close($curl);
            
            $notificationLog->update([
                'status' => 'sent',
                'sent_at' => now()
            ]);
            
            Log::info("WhatsApp sent to {$phone}: {$response}");
        } catch (\Exception $e) {
            $notificationLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            Log::error("WhatsApp failed to {$phone}: " . $e->getMessage());
        }
    }
    
    private function sendSMS($phone, $message)
    {
        try {
            $sid = env('SMS_SID');
            $token = env('SMS_TOKEN');
            $from = env('SMS_FROM');
            
            if (!$sid || !$token || !$from) {
                Log::info("SMS (not configured): {$phone} - {$message}");
                return;
            }
            
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
            
            $data = [
                'From' => $from,
                'To' => $phone,
                'Body' => $message
            ];
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($data),
                CURLOPT_USERPWD => $sid . ':' . $token,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded'
                ]
            ]);
            
            $response = curl_exec($curl);
            curl_close($curl);
            
            Log::info("SMS sent to {$phone}: {$response}");
        } catch (\Exception $e) {
            Log::error("SMS failed to {$phone}: " . $e->getMessage());
        }
    }
    
    public function sendIncompleteRegistrationReminder($user)
    {
        $this->sendEmail($user->email, 'Reminder: Lengkapi Pendaftaran Anda', 'emails.incomplete-registration-reminder', [
            'name' => $user->name,
            'days_left' => 4
        ]);
        
        $this->sendWhatsApp($user->phone, "Halo {$user->name}, pendaftaran SPMB Anda belum lengkap. Silakan login dan lengkapi data pendaftaran segera.");
        
        Log::info("Incomplete registration reminder sent to {$user->email}");
    }
    
    public function sendPaymentReminder(Pendaftaran $pendaftaran)
    {
        $user = $pendaftaran->user;
        
        $this->sendEmail($user->email, 'Reminder: Segera Lakukan Pembayaran', 'emails.payment-reminder', [
            'name' => $pendaftaran->nama_lengkap,
            'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
            'jurusan' => $pendaftaran->jurusan->nama,
            'biaya' => 'Rp 5.500.000'
        ]);
        
        $this->sendWhatsApp($user->phone, "Halo {$pendaftaran->nama_lengkap}, jangan lupa lakukan pembayaran pendaftaran sebesar Rp 5.500.000 dan upload bukti pembayaran.");
        
        Log::info("Payment reminder sent to {$user->email}");
    }
    
    public function sendVerificationWaitingReminder(Pendaftaran $pendaftaran)
    {
        $user = $pendaftaran->user;
        
        $this->sendEmail($user->email, 'Update: Pembayaran Sedang Diverifikasi', 'emails.verification-waiting-reminder', [
            'name' => $pendaftaran->nama_lengkap,
            'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran
        ]);
        
        $this->sendWhatsApp($user->phone, "Halo {$pendaftaran->nama_lengkap}, bukti pembayaran Anda sedang dalam proses verifikasi. Mohon tunggu konfirmasi lebih lanjut.");
        
        Log::info("Verification waiting reminder sent to {$user->email}");
    }
}