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
            $table->foreignUuid('item_uuid')->unique();
            $table->foreignUuid('user_uuid');

            $table->unsignedDecimal('current_price')->default(0.00);
            $table->unsignedDecimal('next_price');

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('bidder_count')->unsigned()->default(0);
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
