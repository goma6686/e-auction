<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()
            ->each(function ($user) {
                $faker = Faker::create();
                $numAuctions = $faker->numberBetween(1, 10);

                for($i = 0; $i < $numAuctions; $i++){
                   
                        $start_time = $faker->dateTimeBetween('-1 month', '+1 month');

                    Auction::create([
                        'uuid' => Uuid::uuid4()->toString(),
                        'title' => $faker->sentence(3),
                        'description' => $faker->paragraph(),
                        'start_time' => $start_time,
                        'end_time' => $faker->dateTimeBetween($start_time, '+1 month'),
                        'category_id' => $faker->numberBetween(1, 8),
                        'is_active' => $faker->boolean(75), // 75% chance of being active
                        'type_id' => 2,
                        'buy_now_price' => $faker->numberBetween(1, 1000),
                        'bidder_count' => $faker->numberBetween(0,123),
                        'user_uuid' => $user->uuid,
                        'reserve_price' => $faker->numberBetween(1, 1000),
                    ]);
                }
            });

            User::factory(10)->create()
            ->each(function ($user) {
                $faker = Faker::create();
                $numAuctions = $faker->numberBetween(1, 10);

                for($i = 0; $i < $numAuctions; $i++){
                    Auction::create([
                        'uuid' => Uuid::uuid4()->toString(),
                        'title' => $faker->sentence(3),
                        'description' => $faker->paragraph(),
                        'start_time' => null,
                        'end_time' => null,
                        'category_id' => $faker->numberBetween(1, 8),
                        'is_active' => $faker->boolean(75), // 75% chance of being active
                        'type_id' => 1,
                        'buy_now_price' => null,
                        'bidder_count' => null,
                        'user_uuid' => $user->uuid,
                        'reserve_price' => null,
                    ]);
                }
            });
    }
}
