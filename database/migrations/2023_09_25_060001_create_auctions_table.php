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
        Schema::create('auctions', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->string('title');
            $table->text('description')->nullable();

            $table->dateTime('end_time')->nullable();

            $table->foreignUuid('user_uuid');
            $table->foreignUuid('category_id');
            $table->foreignUuid('type_id');

            $table->unsignedDecimal('buy_now_price')->nullable();//for Auction
            $table->unsignedDecimal('price')->nullable();//for Auction with multiple items
            $table->unsignedDecimal('reserve_price')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
