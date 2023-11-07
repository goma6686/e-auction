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
        User::factory(20)->create()
            ->each(function ($user) {
                $faker = Faker::create();
                $numAuctions = $faker->numberBetween(1, 10);

                for($i = 0; $i < $numAuctions; $i++){
                    Auction::create([
                        'uuid' => Uuid::uuid4()->toString(),
                        'start_time' => $faker->dateTimeBetween('-1 month', '+1 month'),
                        'end_time' => $faker->dateTimeBetween('+1 week', '+1 month'),
                        'is_active' => $faker->boolean(75), // 75% chance of being active
                        'bidder_count' => $faker->numberBetween(0,123),
                        'user_uuid' => $user->uuid,
                    ]);
                }
            });
    }
}
