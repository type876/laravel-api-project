<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    protected string $baseUrl;
    protected string $token;
    protected string $tokenType;
    protected int $defaultLimit = 500;

    protected $logger;

    public function __construct(string $baseUrl, string $token, string $tokenType = 'api-key', callable $logger = null)
    {
        $this->baseUrl   = rtrim($baseUrl, '/');
        $this->token     = $token;
        $this->tokenType = strtolower($tokenType);
        $this->logger    = $logger;

        $this->log("ApiClient initialized [type={$this->tokenType}]: {$this->baseUrl}");
    }

    protected function log(string $message)
    {
        if (is_callable($this->logger)) {
            call_user_func($this->logger, $message);
        }
    }

    protected function buildHeaders(): array
    {
        if ($this->tokenType === 'bearer') {
            return [
                'Authorization' => 'Bearer ' . $this->token,
            ];
        }

        return [];
    }

    protected function buildQueryParams(array $params): array
    {
        if ($this->tokenType === 'api-key') {
            $params['key'] = $this->token;
        }
        return $params;
    }

    protected function requestWithRetry($method, $url, $params = [], $maxAttempts = 5)
    {
        $attempt = 1;

        while ($attempt <= $maxAttempts) {

            $this->log("Попытка №$attempt: $method $url с параметрами " . json_encode($params));

            $response = Http::timeout(30)
                ->withHeaders($this->buildHeaders())
                ->$method($url, $params);

            if ($response->successful()) {
                $this->log("Успех: HTTP {$response->status()}");
                return $response;
            }

            if ($response->status() === 429) {
                $retryAfter = $response->header('Retry-After');

                if ($retryAfter) {
                    $this->log("429 — ждем {$retryAfter} сек");
                    sleep((int)$retryAfter);
                } else {
                    $delay = $attempt * 2;
                    $this->log("429 — повтор через {$delay} сек");
                    sleep($delay);
                }

                $attempt++;
                continue;
            }

            if ($response->serverError()) {
                $delay = $attempt * 2;
                $this->log("Server error {$response->status()} — ждем {$delay} сек");
                sleep($delay);
                $attempt++;
                continue;
            }

            $this->log("Ошибка API {$response->status()}: {$response->body()}");
            throw new \Exception("API error: {$response->status()} - {$response->body()}");
        }

        throw new \Exception("Max attempts exceeded for API request: $url");
    }

    public function fetchAllPages(string $endpoint, array $params = [], int $limit = null)
    {
        $limit = $limit ?? $this->defaultLimit;
        $page  = 1;

        while (true) {
            $query = array_merge($params, [
                'page'  => $page,
                'limit' => $limit,
            ]);

            $query = $this->buildQueryParams($query);


            $url = $this->baseUrl . $endpoint;

            $response = $this->requestWithRetry('get', $url, $query);

            $json = $response->json();

            $data = $json['data'] ?? $json;

            if (empty($data)) break;

            yield $data;

            if (count($data) < $limit) break;

            $page++;
        }
    }
}
