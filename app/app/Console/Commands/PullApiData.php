<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Income;

class PullApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:api-data';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Подтягивает все данные с API и сохраняет их в базу';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new \App\Services\ApiClient();


        foreach ($client->getSales(['dateFrom' => '2025-10-01','dateTo'=>'2025-10-29']) as $page) {

            foreach ($page as $item) {
                Sale::updateOrCreate(
                    ['external_id' => $item['id'] ?? null],
                    [
                        'payload' => $item,
                        'occurred_at' => $item['date'] ?? null
                    ]
                );
            }

        }

        $this->info('Sales успешно загружены');

        foreach ($client->getOrders(['dateFrom' => '2025-10-01', 'dateTo' => '2025-10-29']) as $page) {
            foreach ($page as $item) {
                Order::updateOrCreate(
                    ['external_id' => $item['id'] ?? null],
                    [
                        'payload' => $item,
                        'occurred_at' => $item['date'] ?? null,
                    ]
                );
            }
        }
        $this->info('Orders загружены');

        foreach ($client->getStocks(['dateFrom' => now()->format('Y-m-d')]) as $page) {
            foreach ($page as $item) {
                Stock::updateOrCreate(
                    ['external_id' => $item['id'] ?? null],
                    [
                        'payload' => $item,
                        'occurred_at' => $item['date'] ?? null,
                    ]
                );
            }
        }
        $this->info('Stocks загружены');

        foreach ($client->getIncomes(['dateFrom' => '2025-10-01', 'dateTo' => '2025-10-29']) as $page) {
            foreach ($page as $item) {
                Income::updateOrCreate(
                    ['external_id' => $item['id'] ?? null],
                    [
                        'payload' => $item,
                        'occurred_at' => $item['date'] ?? null,
                    ]
                );
            }
        }
        $this->info('Incomes загружены');

        $this->info('Все данные успешно подтянуты и сохранены!');
    }
}
