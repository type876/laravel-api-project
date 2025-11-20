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
        \App\Console\Commands\CreateCompany::class,
        \App\Console\Commands\CreateAccount::class,
        \App\Console\Commands\CreateApiService::class,
        \App\Console\Commands\CreateTokenType::class,
        \App\Console\Commands\CreateToken::class,
    ];

    /**
     * Определяет расписание задач.
     */
    protected function schedule(Schedule $schedule)
    {

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
