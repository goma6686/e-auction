<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
                ['id' => '1', 'category' => 'SPORTS'],
                ['id' => '2', 'category' => 'JEWELRY'],
                ['id' => '3', 'category' => 'WATCHES'],
                ['id' => '4', 'category' => 'ELECTRONICS'],
                ['id' => '5', 'category' => 'FASHION'],
                ['id' => '6', 'category' => 'TOYS'],
                ['id' => '7', 'category' => 'HOME'],
                ['id' => '8', 'category' => 'OTHER'],
        ]);
    }
}
