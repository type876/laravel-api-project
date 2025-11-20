<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiService;

class CreateApiService extends Command
{
    protected $signature = 'create:apiservice {name}';

    protected $description = 'Создать новый API сервис';

    public function handle()
    {
        $name = trim($this->argument('name'));

        if (empty($name)) {
            $this->error('Название API сервиса не может быть пустым.');
            return 1;
        }

        $baseUrl = $this->ask('Введите базовый URL API сервиса');

        if (empty($baseUrl)) {
            $this->error('Base URL не может быть пустым.');
            return 1;
        }

        $service = ApiService::create([
            'name'     => $name,
            'base_url' => $baseUrl,
        ]);

        $this->info("API сервис '{$service->name}' успешно создан с base_url: {$service->base_url} с ID: {$service->id}");
        return 0;
    }
}
