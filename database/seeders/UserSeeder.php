<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Models\Item;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'uuid' => Uuid::uuid4()->toString(),
            'username' => 'admin',
            'is_admin' => true,
            'password' => Hash::make('123'),
        ]);
    }
}
