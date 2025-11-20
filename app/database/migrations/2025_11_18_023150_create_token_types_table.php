<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenTypesTable extends Migration

{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('token_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_service_id')->constrained()->onDelete('cascade');
            $table->string('name'); // bearer, api-key, login-password и т.д.
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['api_service_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_types');
    }
};
