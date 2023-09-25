<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ConditionSeeder::class,
            CategorySeeder::class,
            ItemSeeder::class,
            AuctionSeeder::class,
        ]);
        $this->command->info('All tables seeded successfully!');
    }
}
