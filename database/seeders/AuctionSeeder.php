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
                $numAuctions = $faker->numberBetween(1, 5);

                for($i = 0; $i < $numAuctions; $i++){

                    Auction::create([
                        'uuid' => Uuid::uuid4()->toString(),
                        'title' => $faker->sentence(3),
                        'description' => $faker->paragraph(),
                        'end_time' => $faker->dateTimeBetween(now(), '+1 month'),
                        'category_id' => $faker->numberBetween(1, 8),
                        'is_active' => $faker->boolean(75), // 75% chance of being active
                        'type_id' => 2,
                        'is_blocked' => $faker->boolean(10), // 10% chance of being blocked
                        'buy_now_price' => $faker->numberBetween(1, 1000),
                        'user_uuid' => $user->uuid,
                        'reserve_price' => $faker->numberBetween(1, 1000),
                        'price' => $faker->randomFloat(4, 0, 1000),
                    ]);
                }
            });

            User::factory(10)->create()
            ->each(function ($user) {
                $faker = Faker::create();
                $numAuctions = $faker->numberBetween(1, 5);

                for($i = 0; $i < $numAuctions; $i++){
                    Auction::create([
                        'uuid' => Uuid::uuid4()->toString(),
                        'title' => $faker->sentence(3),
                        'description' => $faker->paragraph(),
                        'end_time' => null,
                        'category_id' => $faker->numberBetween(1, 8),
                        'is_active' => $faker->boolean(75), // 75% chance of being active
                        'is_blocked' => $faker->boolean(10), // 10% chance of being blocked
                        'type_id' => 1,
                        'buy_now_price' => null,
                        'user_uuid' => $user->uuid,
                        'reserve_price' => null,
                        'price' => null,
                    ]);
                }
            });
    }
}
