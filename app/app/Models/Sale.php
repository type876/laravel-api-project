<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'spp',
        'odid',
        'brand',
        'nm_id',
        'barcode',
        'for_pay',
        'sale_id',
        'subject',
        'category',
        'g_number',
        'income_id',
        'is_storno',
        'is_supply',
        'tech_size',
        'region_name',
        'total_price',
        'country_name',
        'finished_price',
        'is_realization',
        'warehouse_name',
        'price_with_disc',
        'discount_percent',
        'last_change_date',
        'supplier_article',
        'oblast_okrug_name',
        'promo_code_discount',
    ];
}
