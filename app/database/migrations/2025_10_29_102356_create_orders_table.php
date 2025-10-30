<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('odid')->nullable();
            $table->string('brand')->nullable();
            $table->string('nm_id')->nullable();
            $table->string('oblast')->nullable();
            $table->string('barcode')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('g_number')->nullable();
            $table->date('cancel_dt')->nullable();
            $table->string('income_id')->nullable();
            $table->boolean('is_cancel')->nullable();
            $table->string('tech_size')->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->string('warehouse_name')->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->date('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();

            $table->timestamps(false);
        });
    }



    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
