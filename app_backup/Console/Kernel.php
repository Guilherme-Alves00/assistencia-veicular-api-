<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\AtualizarCoordenadasPrestadores::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Exemplo: $schedule->command('inspire')->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
