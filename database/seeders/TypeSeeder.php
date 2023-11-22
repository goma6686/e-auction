<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->delete();

        DB::table('types')->insert([
                ['id' => '1', 'type' => 'Buy Now'],
                ['id' => '2', 'type' => 'Auction']
        ]);
    }
}
