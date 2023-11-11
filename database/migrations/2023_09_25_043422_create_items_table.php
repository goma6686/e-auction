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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->string('title')->nullable();
            $table->string('image')->nullable();

            $table->foreignUuid('auction_uuid');
            $table->foreignUuid('condition_id');

            $table->unsignedDecimal('current_price')->default(0.00)->nullable();//not all items are in an auction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['condition_uuid']);
            $table->dropForeign(['category_uuid']);
        });
        Schema::dropIfExists('items');
    }
};
