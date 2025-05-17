<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Daily optimization and cache clearing
        $schedule->command('route:cache')->daily();
        $schedule->command('view:cache')->daily();
        $schedule->command('config:cache')->daily();

        // Schedule sitemap generation daily
        $schedule->call(function () {
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            (new \App\Http\Controllers\SitemapController)->index();
        })->everyMinute(); // For testing, runs every minute

        // Log a message after successful generation
        $schedule->call(function () {
            \Log::info('✅ Sitemap generated successfully at ' . now());
        })->everyMinute(); // For testing, runs every minute
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
