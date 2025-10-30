<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'odid',
        'brand',
        'nm_id',
        'oblast',
        'barcode',
        'subject',
        'category',
        'g_number',
        'cancel_dt',
        'income_id',
        'is_cancel',
        'tech_size',
        'total_price',
        'warehouse_name',
        'discount_percent',
        'last_change_date',
        'supplier_article',
    ];
}
