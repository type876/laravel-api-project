<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TokenType;
use App\Models\ApiService;

class CreateTokenType extends Command
{
    protected $signature = 'create:token-type';

    protected $description = 'Создать новый тип токена (TokenType) с возможной привязкой к API сервису';

    public function handle()
    {
        $this->info('Создание нового типа токена');

        $name = $this->ask('Введите имя типа токена');

        if (!$name) {
            $this->error('Имя типа токена не может быть пустым.');
            return 1;
        }

        $tokenType = TokenType::create([
            'name' => $name,
        ]);

        $apiServices = ApiService::pluck('name', 'id')->toArray();

        if (!empty($apiServices)) {
            $attach = $this->confirm('Хотите привязать этот тип токена к API сервису?', false);

            if ($attach) {
                $apiServiceId = $this->choice('Выберите API сервис', $apiServices);

                $apiService = ApiService::find($apiServiceId);
                $apiService->tokenTypes()->attach($tokenType->id);

                $this->info("Тип токена '{$name}' создан и привязан к API сервису '{$apiService->name}'.");
                return 0;
            }
        }

        $this->info("Тип токена '{$name}' успешно создан без привязки к API сервисам.");
        return 0;
    }
}
