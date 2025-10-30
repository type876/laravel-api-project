<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->string('spp')->nullable();
            $table->string('odid')->nullable();
            $table->string('brand')->nullable();
            $table->string('nm_id')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('for_pay', 12, 2)->nullable();
            $table->string('sale_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('g_number')->nullable();
            $table->string('income_id')->nullable();
            $table->boolean('is_storno')->nullable();
            $table->boolean('is_supply')->nullable();
            $table->string('tech_size')->nullable();
            $table->string('region_name')->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->string('country_name')->nullable();
            $table->decimal('finished_price', 12, 2)->nullable();
            $table->boolean('is_realization')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->decimal('price_with_disc', 12, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->dateTime('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->string('oblast_okrug_name')->nullable();
            $table->decimal('promo_code_discount', 12, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');

    }

};
