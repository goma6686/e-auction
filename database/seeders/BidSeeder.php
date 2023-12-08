<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Database\Seeder;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $userUUids = User::pluck('uuid')->toArray();
        $auctionUUids = Auction::pluck('uuid')->toArray();

        foreach (range(1, 100) as $index) {
            DB::table('bids')->insert([
                'uuid' => $faker->uuid,
                'user_uuid' => $faker->randomElement($userUUids),
                'auction_uuid' => $faker->randomElement($auctionUUids),
                'amount' => $faker->randomFloat(2, 0, 1000),
                'is_winning' => $faker->boolean,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }

    }
}
