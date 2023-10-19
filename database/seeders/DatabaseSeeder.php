<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create()
            ->each(function ($user) {
                $faker = Faker::create();
                Item::create([
                    'uuid' => Uuid::uuid4()->toString(),
                    'user_uuid' => $user->uuid,
                    'title' => $faker->sentence(3),
                    'description' => $faker->paragraph(),
                    'condition_id' => $faker->numberBetween(1, 6),
                    'category_id' => $faker->numberBetween(1, 8),
                    'current_price' => $faker->randomFloat(4, 0, 1000),
                ]);
            });

        $this->call([
            ConditionSeeder::class,
            CategorySeeder::class,
            AuctionSeeder::class,
        ]);

        $this->command->info('All tables seeded successfully!');
    }
}
