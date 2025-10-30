<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->string('nm_id')->nullable();
            $table->string('number')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('income_id')->nullable();
            $table->string('tech_size')->nullable();
            $table->date('date_close')->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->string('warehouse_name')->nullable();
            $table->date('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();

            $table->timestamps(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
