<?php

namespace App\Listeners;

use App\Services\NotificationService;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class SendNotificationListener
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle($event)
    {
        $this->logAuditEvent($event);
        
        switch (get_class($event)) {
            case 'App\Events\UserRegistered':
                $this->notificationService->sendAccountActivation($event->user);
                break;
                
            case 'App\Events\DocumentRejected':
                $this->notificationService->sendDocumentRevision($event->pendaftaran, $event->message);
                break;
                
            case 'App\Events\DocumentApproved':
                $this->notificationService->sendPaymentInstructions($event->pendaftaran);
                break;
                
            case 'App\Events\VerificationCompleted':
                $this->notificationService->sendVerificationResult($event->pendaftaran, $event->status, $event->message);
                break;
        }
    }

    private function logAuditEvent($event)
    {
        $user = Auth::user();
        $eventClass = get_class($event);
        
        AuditLog::create([
            'user_id' => $user ? $user->id : null,
            'action' => 'notification_triggered',
            'model_type' => $eventClass,
            'model_id' => property_exists($event, 'pendaftaran') ? $event->pendaftaran->id : null,
            'old_values' => null,
            'new_values' => ['event' => $eventClass, 'timestamp' => now()],
            'ip_address' => request()->ip() ?? '127.0.0.1'
        ]);
    }
}