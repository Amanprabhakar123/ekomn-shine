<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('image:compression')->everyMinute()->withoutOverlapping();
        $schedule->command('process:bulk-upload-product')->everyMinute()->withoutOverlapping();
        $schedule->command('app:process-bulk-upload-payment')->everyMinute()->withoutOverlapping();
        $schedule->command('app:change-payment-refund-status')->everySixHours()->withoutOverlapping();
        $schedule->command('app:process-supplier-payment-statement')->everyMinute()->withoutOverlapping();
        $schedule->command('app:process-return-order-payment')->everyMinute()->withoutOverlapping();
        $schedule->command('app:inactive-expired-subscription')->dailyAt('00:10')->withoutOverlapping();
        $schedule->command('app:yearly-plan-download-count-every-month')->dailyAt('00:30')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
