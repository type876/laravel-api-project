<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'date',
        'brand',
        'nm_id',
        'price',
        'barcode',
        'sc_code',
        'subject',
        'category',
        'discount',
        'quantity',
        'is_supply',
        'tech_size',
        'quantity_full',
        'is_realization',
        'warehouse_name',
        'in_way_to_client',
        'last_change_date',
        'supplier_article',
        'in_way_from_client',
    ];
}
