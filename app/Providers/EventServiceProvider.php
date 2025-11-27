<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserRegistered;
use App\Events\DocumentRejected;
use App\Events\DocumentApproved;
use App\Events\VerificationCompleted;
use App\Listeners\SendNotificationListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendNotificationListener::class,
        ],
        DocumentRejected::class => [
            SendNotificationListener::class,
        ],
        DocumentApproved::class => [
            SendNotificationListener::class,
        ],
        VerificationCompleted::class => [
            SendNotificationListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}