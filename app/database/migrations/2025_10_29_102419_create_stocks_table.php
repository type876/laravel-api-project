<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('external_id')->nullable();
            $table->date('date')->nullable();
            $table->string('brand')->nullable();
            $table->string('nm_id')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('barcode')->nullable();
            $table->string('sc_code')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->boolean('is_supply')->nullable();
            $table->string('tech_size')->nullable();
            $table->decimal('quantity_full', 12, 2)->nullable();
            $table->boolean('is_realization')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->decimal('in_way_to_client', 12, 2)->nullable();
            $table->date('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->decimal('in_way_from_client', 12, 2)->nullable();
            $table->date('occurred_at')->nullable();

            $table->timestamps(false); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
