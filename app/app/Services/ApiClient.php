<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Income;

class ApiClient
{
    protected string $baseUrl;
    protected string $token;
    protected int $defaultLimit = 500;

    public function __construct()
    {
        $this->baseUrl = config('services.testapi.base_url');
        $this->token = config('services.testapi.token');
    }


    public function fetchAllPages(string $endpoint, array $params = [], int $limit = null)
    {
        $limit = $limit ?? $this->defaultLimit;
        $page = 1;

        while (true) {
            $query = array_merge($params, [
                'page' => $page,
                'limit' => $limit,
                'key' => $this->token,
            ]);

            $response = Http::timeout(30)->get($this->baseUrl . $endpoint, $query);

            if (!$response->successful()) {
                throw new \Exception("Ошибка API: " . $response->status());
            }

            $data = $response->json()['data'] ?? $response->json();

            if (empty($data)) break;

            yield $data;

            if (count($data) < $limit) break;

            $page++;
        }
    }

    public function getSales($params = [], $limit = null) { return $this->fetchAllPages('/api/sales', $params, $limit); }
    public function getOrders($params = [], $limit = null) { return $this->fetchAllPages('/api/orders', $params, $limit); }
    public function getStocks($params = [], $limit = null) { return $this->fetchAllPages('/api/stocks', $params, $limit); }
    public function getIncomes($params = [], $limit = null) { return $this->fetchAllPages('/api/incomes', $params, $limit); }
}
