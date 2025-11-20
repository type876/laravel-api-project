<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Token;
use App\Models\Account;
use App\Models\ApiService;
use App\Models\TokenType;

class CreateToken extends Command
{
    protected $signature = 'create:token';

    protected $description = 'Создать новый API токен';

    public function handle()
    {
        $this->info('Создание нового токена');

        $accounts = Account::pluck('name', 'id')->toArray();
        if (empty($accounts)) {
            $this->error('Нет доступных аккаунтов. Создайте аккаунт сначала.');
            return 1;
        }

        $accountName = $this->choice('Выберите аккаунт', $accounts);
        $accountId = array_search($accountName, $accounts);

        $apiServices = ApiService::pluck('name', 'id')->toArray();
        if (empty($apiServices)) {
            $this->error('Нет доступных API сервисов. Создайте API сервис сначала.');
            return 1;
        }

        $apiServiceName = $this->choice('Выберите API сервис', $apiServices);
        $apiServiceId = array_search($apiServiceName, $apiServices);

        $apiService = ApiService::find($apiServiceId);

        if (!$apiService) {
            $this->error('Ошибка: выбранный API сервис не найден.');
            return 1;
        }

        $tokenTypes = $apiService->tokenTypes()
            ->select('token_types.id', 'token_types.name')
            ->pluck('token_types.name', 'token_types.id')
            ->toArray();

        if (empty($tokenTypes)) {
            $this->error('Нет доступных типов токена для выбранного API сервиса. Создайте тип токена сначала.');
            return 1;
        }

        $tokenTypeName = $this->choice('Выберите тип токена', $tokenTypes);
        $tokenTypeId = array_search($tokenTypeName, $tokenTypes);

        $tokenValue = $this->secret('Введите значение токена');

        if (!$tokenValue) {
            $this->error('Значение токена не может быть пустым.');
            return 1;
        }


        Token::create([
            'account_id'      => $accountId,
            'api_service_id'  => $apiServiceId,
            'token_type_id'   => $tokenTypeId,
            'value'           => $tokenValue,
        ]);

        $this->info('Токен успешно создан!');
        return 0;
    }
}
