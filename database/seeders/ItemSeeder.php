<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Auction;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (Auction::all() as $auction) {
            $faker = Faker::create();
            $numItems = $faker->numberBetween(1, 10);

            for($i = 0; $i < $numItems; $i++){
                Item::create([
                    'uuid' => Uuid::uuid4()->toString(),
                    'title' => $faker->sentence(3),
                    'description' => $faker->paragraph(),
    
                    'auction_uuid' => $auction->uuid,
                    'condition_id' => $faker->numberBetween(1, 6),
                    'category_id' => $faker->numberBetween(1, 8),
                    'user_uuid' => $auction->user_uuid,
    
                    'current_price' => $faker->randomFloat(4, 0, 1000),
                    'next_price' => $faker->randomFloat(4, 0, 1000),
                ]);
            }
            
        }
    }
}
