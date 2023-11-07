<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Auction;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            ConditionSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            AuctionSeeder::class,
            ItemSeeder::class,
        ]);

        $this->command->info('All tables seeded successfully!');
    }
}
