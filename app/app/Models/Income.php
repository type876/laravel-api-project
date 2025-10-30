<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'date',
        'nm_id',
        'number',
        'barcode',
        'quantity',
        'income_id',
        'tech_size',
        'date_close',
        'total_price',
        'warehouse_name',
        'last_change_date',
        'supplier_article',
    ];
}
