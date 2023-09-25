<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\Item;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (Item::all() as $item) {
            Auction::create([
                'uuid' => Uuid::uuid4()->toString(),
                'item_id' => $item->uuid,
                'user_id' => $item->user_id,
                'current_price' => $item->current_price,
                'next_price' => $item->current_price + $faker->randomFloat(2, 1, 100), //TODO: prieaugiai pagal kainą
                'start_time' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'end_time' => $faker->dateTimeBetween('now', '+1 month'),
                'is_active' => $faker->boolean(75), // 75% chance of being active
                'bidder_count' => $faker->numberBetween(0,123),
            ]);
        }
    }
}
