<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Зарегистрированные команды Artisan.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\PullApiData::class,
    ];

    /**
     * Определяет расписание задач.
     */
    protected function schedule(Schedule $schedule)
    {
        // Здесь можно планировать команду на cron, если нужно
    }

    /**
     * Регистрация всех команд для Artisan.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
