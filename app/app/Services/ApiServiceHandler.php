<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Income;

class ApiServiceHandler
{
    protected ApiClient $client;
    protected int $accountId;
    protected $logger;

    public function __construct(
        string $baseUrl,
        string $token,
        string $tokenType,
        int $accountId,
        callable $logger = null
    ) {
        $this->client = new ApiClient($baseUrl, $token, $tokenType);
        $this->accountId = $accountId;
        $this->logger = $logger;
    }

    protected function info(string $msg)
    {
        if ($this->logger) {
            call_user_func($this->logger, $msg);
        }
    }

    public function run()
    {
        $this->info("Запуск работы ApiServiceHandler для аккаунта {$this->accountId}");

        $this->loadSales();
        $this->loadOrders();
        $this->loadStocks();
        $this->loadIncomes();

        $this->info("Все данные успешно загружены для аккаунта: {$this->accountId}");
    }

    protected function load(string $endpoint, string $modelClass, array $params, array $mapping)
    {
        $modelClass::where('account_id', $this->accountId)->delete();

        foreach ($this->client->fetchAllPages($endpoint, $params) as $page) {

            foreach ($page as $item) {
                if (!$item) continue;

                $data = ['account_id' => $this->accountId];

                foreach ($mapping as $field => $src) {
                    $data[$field] = $item[$src] ?? null;
                }

                $modelClass::create($data);
            }
        }

        $this->info($modelClass . " data loaded");
    }

    public function loadSales()
    {
        $this->load(
            '/api/sales',
            Sale::class,
            [
                'dateFrom' => date('Y-m-d', strtotime('-1 day')),
                'dateTo'   => date('Y-m-d'),
            ],
            [
                'spp'                 => 'spp',
                'odid'                => 'odid',
                'brand'               => 'brand',
                'nm_id'               => 'nm_id',
                'barcode'             => 'barcode',
                'for_pay'             => 'for_pay',
                'sale_id'             => 'sale_id',
                'subject'             => 'subject',
                'category'            => 'category',
                'g_number'            => 'g_number',
                'income_id'           => 'income_id',
                'is_storno'           => 'is_storno',
                'is_supply'           => 'is_supply',
                'tech_size'           => 'tech_size',
                'region_name'         => 'region_name',
                'total_price'         => 'total_price',
                'country_name'        => 'country_name',
                'finished_price'      => 'finished_price',
                'is_realization'      => 'is_realization',
                'warehouse_name'      => 'warehouse_name',
                'price_with_disc'     => 'price_with_disc',
                'discount_percent'    => 'discount_percent',
                'last_change_date'    => 'last_change_date',
                'supplier_article'    => 'supplier_article',
                'oblast_okrug_name'   => 'oblast_okrug_name',
                'promo_code_discount' => 'promo_code_discount',
            ]
        );

        $this->info("Sales успешно загружены");
    }

    public function loadOrders()
    {
        $this->load(
            '/api/orders',
            Order::class,
            [
                'dateFrom' => date('Y-m-d', strtotime('-1 day')),
                'dateTo'   => date('Y-m-d'),
            ],
            [
                'odid'             => 'odid',
                'brand'            => 'brand',
                'nm_id'            => 'nm_id',
                'oblast'           => 'oblast',
                'barcode'          => 'barcode',
                'subject'          => 'subject',
                'category'         => 'category',
                'g_number'         => 'g_number',
                'cancel_dt'        => 'cancel_dt',
                'income_id'        => 'income_id',
                'is_cancel'        => 'is_cancel',
                'tech_size'        => 'tech_size',
                'total_price'      => 'total_price',
                'warehouse_name'   => 'warehouse_name',
                'discount_percent' => 'discount_percent',
                'last_change_date' => 'last_change_date',
                'supplier_article' => 'supplier_article',
            ]
        );

        $this->info("Orders успешно загружены");
    }

    public function loadStocks()
    {
        $this->load(
            '/api/stocks',
            Stock::class,
            ['dateFrom' => date('Y-m-d')],
            [
                'date'               => 'date',
                'brand'              => 'brand',
                'nm_id'              => 'nm_id',
                'price'              => 'price',
                'barcode'            => 'barcode',
                'sc_code'            => 'sc_code',
                'subject'            => 'subject',
                'category'           => 'category',
                'discount'           => 'discount',
                'quantity'           => 'quantity',
                'is_supply'          => 'is_supply',
                'tech_size'          => 'tech_size',
                'quantity_full'      => 'quantity_full',
                'is_realization'     => 'is_realization',
                'warehouse_name'     => 'warehouse_name',
                'in_way_to_client'   => 'in_way_to_client',
                'last_change_date'   => 'last_change_date',
                'supplier_article'   => 'supplier_article',
                'in_way_from_client' => 'in_way_from_client',
            ]
        );

        $this->info("Stocks успешно загружены");
    }

    public function loadIncomes()
    {
        $this->load(
            '/api/incomes',
            Income::class,
            [
                'dateFrom' => date('Y-m-d', strtotime('-1 day')),
                'dateTo'   => date('Y-m-d'),
            ],
            [
                'date'             => 'date',
                'nm_id'            => 'nm_id',
                'number'           => 'number',
                'barcode'          => 'barcode',
                'quantity'         => 'quantity',
                'income_id'        => 'income_id',
                'tech_size'        => 'tech_size',
                'date_close'       => 'date_close',
                'total_price'      => 'total_price',
                'warehouse_name'   => 'warehouse_name',
                'last_change_date' => 'last_change_date',
                'supplier_article' => 'supplier_article',
            ]
        );

        $this->info("Incomes успешно загружены");
    }
}
