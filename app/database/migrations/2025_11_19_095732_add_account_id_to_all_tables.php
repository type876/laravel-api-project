<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->index();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->index();
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->index();
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });
    }

};
