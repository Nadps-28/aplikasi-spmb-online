<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Pendaftaran;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReminderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $user = User::find($this->userId);
        
        if (!$user) {
            return;
        }

        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        
        if (!$pendaftaran) {
            // Send incomplete registration reminder
            $notificationService = new NotificationService();
            $notificationService->sendIncompleteRegistrationReminder($user);
        }
    }
}