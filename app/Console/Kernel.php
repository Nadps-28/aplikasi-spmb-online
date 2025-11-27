<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        // Send reminder notifications every day at 9 AM
        $schedule->command('notifications:send-reminders')->dailyAt('09:00');
        
        // Process queue jobs
        $schedule->command('queue:work --stop-when-empty')->everyMinute();
        
        // Clean up old jobs every day at midnight
        $schedule->command('queue:prune-failed --hours=48')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}