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
                if ($item !== null) {
                    Sale::create([
                        'spp' => $item['spp'] ?? null,
                        'odid' => $item['odid'] ?? null,
                        'brand' => $item['brand'] ?? null,
                        'nm_id' => $item['nm_id'] ?? null,
                        'barcode' => $item['barcode'] ?? null,
                        'for_pay' => $item['for_pay'] ?? null,
                        'sale_id' => $item['sale_id'] ?? null,
                        'subject' => $item['subject'] ?? null,
                        'category' => $item['category'] ?? null,
                        'g_number' => $item['g_number'] ?? null,
                        'income_id' => $item['income_id'] ?? null,
                        'is_storno' => $item['is_storno'] ?? null,
                        'is_supply' => $item['is_supply'] ?? null,
                        'tech_size' => $item['tech_size'] ?? null,
                        'region_name' => $item['region_name'] ?? null,
                        'total_price' => $item['total_price'] ?? null,
                        'country_name' => $item['country_name'] ?? null,
                        'finished_price' => $item['finished_price'] ?? null,
                        'is_realization' => $item['is_realization'] ?? null,
                        'warehouse_name' => $item['warehouse_name'] ?? null,
                        'price_with_disc' => $item['price_with_disc'] ?? null,
                        'discount_percent' => $item['discount_percent'] ?? null,
                        'last_change_date' => $item['last_change_date'] ?? null,
                        'supplier_article' => $item['supplier_article'] ?? null,
                        'oblast_okrug_name' => $item['oblast_okrug_name'] ?? null,
                        'promo_code_discount' => $item['promo_code_discount'] ?? null,
                    ]);
                }
            }
        }


        $this->info('Sales успешно загружены');
        foreach ($client->getOrders(['dateFrom' => '2025-10-01', 'dateTo'=>'2025-10-29']) as $page) {
            foreach ($page as $item) {
                if ($item !== null) {
                    Order::create([
                        'odid' => $item['odid'] ?? null,
                        'brand' => $item['brand'] ?? null,
                        'nm_id' => $item['nm_id'] ?? null,
                        'oblast' => $item['oblast'] ?? null,
                        'barcode' => $item['barcode'] ?? null,
                        'subject' => $item['subject'] ?? null,
                        'category' => $item['category'] ?? null,
                        'g_number' => $item['g_number'] ?? null,
                        'cancel_dt' => $item['cancel_dt'] ?? null,
                        'income_id' => $item['income_id'] ?? null,
                        'is_cancel' => $item['is_cancel'] ?? null,
                        'tech_size' => $item['tech_size'] ?? null,
                        'total_price' => $item['total_price'] ?? null,
                        'warehouse_name' => $item['warehouse_name'] ?? null,
                        'discount_percent' => $item['discount_percent'] ?? null,
                        'last_change_date' => $item['last_change_date'] ?? null,
                        'supplier_article' => $item['supplier_article'] ?? null,
                    ]);
                }
            }
        }

        $this->info('Orders загружены');


        foreach ($client->getStocks(['dateFrom' => now()->format('Y-m-d')]) as $page) {
            foreach ($page as $item) {
                if ($item !== null) {
                    Stock::create([
                        'date' => $item['date'] ?? null,
                        'brand' => $item['brand'] ?? null,
                        'nm_id' => $item['nm_id'] ?? null,
                        'price' => $item['price'] ?? null,
                        'barcode' => $item['barcode'] ?? null,
                        'sc_code' => $item['sc_code'] ?? null,
                        'subject' => $item['subject'] ?? null,
                        'category' => $item['category'] ?? null,
                        'discount' => $item['discount'] ?? null,
                        'quantity' => $item['quantity'] ?? null,
                        'is_supply' => $item['is_supply'] ?? null,
                        'tech_size' => $item['tech_size'] ?? null,
                        'quantity_full' => $item['quantity_full'] ?? null,
                        'is_realization' => $item['is_realization'] ?? null,
                        'warehouse_name' => $item['warehouse_name'] ?? null,
                        'in_way_to_client' => $item['in_way_to_client'] ?? null,
                        'last_change_date' => $item['last_change_date'] ?? null,
                        'supplier_article' => $item['supplier_article'] ?? null,
                        'in_way_from_client' => $item['in_way_from_client'] ?? null,
                    ]);
                }
            }
        }



        $this->info('Stocks загружены');

        foreach ($client->getIncomes(['dateFrom' => '2025-10-01','dateTo'=>'2025-10-29']) as $page) {
            foreach ($page as $item) {
                if ($item !== null) {
                    Income::create([
                        'date' => $item['date'] ?? null,
                        'nm_id' => $item['nm_id'] ?? null,
                        'number' => $item['number'] ?? null,
                        'barcode' => $item['barcode'] ?? null,
                        'quantity' => $item['quantity'] ?? null,
                        'income_id' => $item['income_id'] ?? null,
                        'tech_size' => $item['tech_size'] ?? null,
                        'date_close' => $item['date_close'] ?? null,
                        'total_price' => $item['total_price'] ?? null,
                        'warehouse_name' => $item['warehouse_name'] ?? null,
                        'last_change_date' => $item['last_change_date'] ?? null,
                        'supplier_article' => $item['supplier_article'] ?? null,
                    ]);
                }
            }
        }

        $this->info('Incomes загружены');

        $this->info('Все данные успешно подтянуты и сохранены!');
    }
}
