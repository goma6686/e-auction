<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use App\Models\Auction;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $admin = User::create([
            'uuid' => Uuid::uuid4()->toString(),
            'email' => 'judesysmail@gmail.com',
            'username' => 'admin',
            'is_admin' => true,
            'password' => Hash::make('123'),
        ]);

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
                'user_uuid' => $admin->uuid,
                'reserve_price' => $faker->numberBetween(1, 1000),
                'price' => $faker->randomFloat(4, 0, 1000),
            ]);
        }

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
                'user_uuid' => $admin->uuid,
                'reserve_price' => null,
                'price' => null,
            ]);
        }


        $tea = User::create([
            'uuid' => Uuid::uuid4()->toString(),
            'email' => 'emailasviskamkitam@gmail.com',
            'username' => 'tea',
            'is_admin' => false,
            'password' => Hash::make('123'),
        ]);

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
                'user_uuid' => $tea->uuid,
                'reserve_price' => $faker->numberBetween(1, 1000),
                'price' => $faker->randomFloat(4, 0, 1000),
            ]);
        }

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
                'user_uuid' => $tea->uuid,
                'reserve_price' => null,
                'price' => null,
            ]);
        }
        
    }
}
