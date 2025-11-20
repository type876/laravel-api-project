<?php
namespace App\Services;

use App\Models\Token;

class ApiServiceRunner
{
    protected $logger;

    public function __construct(callable $logger = null)
    {
        $this->logger = $logger;
    }

    protected function log($msg)
    {
        if ($this->logger) {
            call_user_func($this->logger, $msg);
        }
    }

    public function runForCompany($company)
    {
        foreach ($company->accounts as $account) {
            $this->log("  Аккаунт #{$account->id}");

            $tokens = Token::where('account_id', $account->id)->get();

            foreach ($tokens as $token) {

                $apiService = $token->apiService;

                if (!$apiService) {
                    $this->log(" ApiService не найден для token {$token->id}");
                    continue;
                }

                $this->log("    API: {$apiService->name}  ({$apiService->base_url})");
                $this->dispatchHandler(
                    $apiService->name,
                    $apiService->base_url,
                    $token->value,
                    $token->tokenType->name,
                    $account->id
                );
            }
        }
    }

    private function dispatchHandler(string $name, string $baseUrl, string $tokenValue, string $tokenType, int
$accountId)
    {
        $handlers = [
            'testovoye' => \App\Services\ApiServiceHandler::class,
        ];

        if (!isset($handlers[$name])) {
            $this->log(" Нет обработчика для API `$name`");
            return;
        }

        $class = $handlers[$name];

        $handler = new $class($baseUrl, $tokenValue, $tokenType, $accountId, $this->logger);
        $handler->run();
    }
}
