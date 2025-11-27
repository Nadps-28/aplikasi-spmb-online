<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Services\NotificationService;
use Carbon\Carbon;

class SendReminderNotifications extends Command
{
    protected $signature = 'notifications:send-reminders';
    protected $description = 'Send reminder notifications to users';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        $this->info('Sending reminder notifications...');

        // 1. Reminder untuk pendaftaran yang belum lengkap (3 hari setelah registrasi)
        $incompleteUsers = User::whereHas('role', function($q) {
            $q->where('nama', 'Calon Siswa');
        })
        ->whereDoesntHave('pendaftaran')
        ->where('created_at', '<=', Carbon::now()->subDays(3))
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->get();

        foreach ($incompleteUsers as $user) {
            $this->notificationService->sendIncompleteRegistrationReminder($user);
            $this->info("Sent incomplete registration reminder to: {$user->email}");
        }

        // 2. Reminder untuk pembayaran yang belum dilakukan (2 hari setelah berkas disetujui)
        $pendingPayments = Pendaftaran::where('status', 'berkas_disetujui')
            ->whereDoesntHave('pembayaran')
            ->where('updated_at', '<=', Carbon::now()->subDays(2))
            ->where('updated_at', '>=', Carbon::now()->subDays(5))
            ->get();

        foreach ($pendingPayments as $pendaftaran) {
            $this->notificationService->sendPaymentReminder($pendaftaran);
            $this->info("Sent payment reminder to: {$pendaftaran->user->email}");
        }

        // 3. Reminder untuk pembayaran yang sedang diverifikasi (5 hari)
        $verificationWaiting = Pendaftaran::whereHas('pembayaran', function($q) {
            $q->where('status', 'menunggu_verifikasi');
        })
        ->whereHas('pembayaran', function($q) {
            $q->where('updated_at', '<=', Carbon::now()->subDays(5));
        })
        ->get();

        foreach ($verificationWaiting as $pendaftaran) {
            $this->notificationService->sendVerificationWaitingReminder($pendaftaran);
            $this->info("Sent verification waiting reminder to: {$pendaftaran->user->email}");
        }

        $this->info('Reminder notifications sent successfully!');
    }
}