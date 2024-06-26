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

            $table->string('title');
            $table->string('image')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('quantity_sold')->default(0);

            $table->foreignUuid('auction_uuid');
            $table->foreignUuid('condition_id');

            $table->unsignedDecimal('price')->nullable();//null for auctions
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
